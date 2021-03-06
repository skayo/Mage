<?php

namespace Controllers;

use Base;
use Helpers\ColorParser;
use Helpers\ImageGenerator;
use Helpers\Utils;
use Intervention\Image\Exception\NotSupportedException;

class Placeholder {

	/**
	 * @param \Base $f3
	 * @param array $params
	 */
	public function render (Base $f3, array $params = []): void {
		$path = $params['*'];
		$options = Utils::parsePath($path, [ [ 'width', 'height' ], 'bgColor', 'textColor' ]);

		$width = (int) ($options['width'] ?? 0);
		$height = (int) ($options['height'] ?? $width);

		$bgColor = ColorParser::parse($options['bgColor'] ?? 'lightgray');
		$textColor = ColorParser::parse($options['textColor'] ?? 'dimgray');

		$format = $options['format'] ?? 'png';
		$mime = Utils::getMimeType($format);

		$text = Utils::getQueryStr() ?? $width . ' x ' . $height;

		if ($width === 0) {
			$f3->error(400, 'Invalid width!');
		} elseif ($height === 0) {
			$f3->error(400, 'Invalid height!');
		} elseif ($bgColor === null) {
			$f3->error(400, 'Invalid background color!');
		} elseif ($textColor === null) {
			$f3->error(400, 'Invalid text color!');
		} elseif ($mime === null) {
			$f3->error(400, 'Unsupported image format!');
		} elseif (Utils::isTooLarge($width, $height)) {
			$f3->error(400, 'Requested image size exceeds limits!');
		}

		$hash = $f3->hash($width . $height . implode('', $bgColor) . implode('', $textColor) . $text);
		$cachePath = "/i/ph.$hash.$format";

		if (is_file($f3->PUBLIC . $cachePath)) {
			$f3->reroute($cachePath);
		}

		$image = ImageGenerator::generatePlaceholder($width, $height, $bgColor, $textColor, $text);

		$image->save($f3->PUBLIC . $cachePath);
		$f3->reroute($cachePath);
	}

}
