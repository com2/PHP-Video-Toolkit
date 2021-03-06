<?php

	/* SVN FILE: $Id$ */
	
	/**
	 * @author Oliver Lillie (aka buggedcom) <publicmail@buggedcom.co.uk>
	 * @package PHPVideoToolkit
	 * @license BSD
	 * @copyright Copyright (c) 2008 Oliver Lillie <http://www.buggedcom.co.uk>
	 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation
	 * files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy,
	 * modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software
	 * is furnished to do so, subject to the following conditions:  The above copyright notice and this permission notice shall be
	 * included in all copies or substantial portions of the Software.
	 *
	 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
	 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
	 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
	 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
	 */

	echo '<html><head><link type="text/css" rel="stylesheet" href="../common/styles.css"><meta name="author" content="Oliver Lillie"></head><body>';
	echo '<a class="backtoexamples" href="../index.php#examples">&larr; Back to examples list</a><br /><br />';
	echo '<strong>This example gives you an encode/decode lookup table so you can see which formats can be encoded and/or decoded with your version of FFmpeg, whilst showing you how to easily check for different codecs..</strong><br /><br />';
	$ignore_demo_files = true;	
	
// 	load the examples configuration
	require_once '../example-config.php';
	
// 	require the library
	require_once '../../phpvideotoolkit.'.$use_version.'.php';
	
// 	get the ffmpeg info
	$formats = PHPVideoToolkit::getAvailableFormats();
	$audio_codecs = PHPVideoToolkit::getAvailableCodecs('audio');
	$video_codecs = PHPVideoToolkit::getAvailableCodecs('video');
	$subtitle_codecs = PHPVideoToolkit::getAvailableCodecs('subtitle');
	
	echo '<table border="0" cellspacing="0" cellpadding="5">
		<tr>
			<td>
				Format Information
			</td>
			<td>
				Codec Information
			</td>
		</tr>
		<tr>
			<td style="padding-right:20px;" valign="top">
				<table border="0" cellspacing="0" cellpadding="5">
					<tr>
						<td style="width:125px;">
							Format
						</td>
						<td style="width:75px;">
							Mux
						</td>
						<td style="width:75px;">
							Demux
						</td>
					</tr>';
		
// 		loop and check availability
	foreach ($formats as $format)
	{
		echo ' 		<tr>
						<td style="border-bottom:1px solid #ccc">
							'.$format.'
						</td>
						<td style="border-bottom:1px solid #ccc">
							'.(PHPVideoToolkit::canFormatBeMuxed($format) ? 'YES' : '&nbsp;').'
						</td>
						<td style="border-bottom:1px solid #ccc">
							'.(PHPVideoToolkit::canFormatBeDemuxed($format) ? 'YES' : '&nbsp;').'
						</td>
					</tr>';
	}
	echo '		</table>
			</td>
	   		<td valign="top">
				<strong>Audio Codecs</strong>
				<table border="0" cellspacing="0" cellpadding="5">
					<tr>
						<td style="width:125px;">
							Format
						</td>
						<td style="width:75px;">
							Encode
						</td>
						<td style="width:75px;">
							Decode
						</td>
					</tr>';
		
// 		loop and check availability
	foreach ($audio_codecs as $codec)
	{
		echo ' 		<tr>
						<td style="border-bottom:1px solid #ccc">
							'.$codec.'
						</td>
						<td style="border-bottom:1px solid #ccc">
							'.(PHPVideoToolkit::canCodecBeEncoded('audio', $codec) ? 'YES' : '&nbsp;').'
						</td>
						<td style="border-bottom:1px solid #ccc">
							'.(PHPVideoToolkit::canCodecBeDecoded('audio', $codec) ? 'YES' : '&nbsp;').'
						</td>
					</tr>';
	}
	echo '		</table>
				<br />
				<br />
				<strong>Video Codecs</strong>
				<table border="0" cellspacing="0" cellpadding="5">
					<tr>
						<td style="width:125px;">
							Format
						</td>
						<td style="width:75px;">
							Encode
						</td>
						<td style="width:75px;">
							Decode
						</td>
					</tr>';
		
// 	loop and check availability
	foreach ($video_codecs as $codec)
	{
		echo ' 		<tr>
						<td style="border-bottom:1px solid #ccc">
							'.$codec.'
						</td>
						<td style="border-bottom:1px solid #ccc">
							'.(PHPVideoToolkit::canCodecBeEncoded('video', $codec) ? 'YES' : '&nbsp;').'
						</td>
						<td style="border-bottom:1px solid #ccc">
							'.(PHPVideoToolkit::canCodecBeDecoded('video', $codec) ? 'YES' : '&nbsp;').'
						</td>
					</tr>';
	}
	echo '		</table>
				<br />
				<br />
				<strong>Subtitle Codecs</strong>
				<table border="0" cellspacing="0" cellpadding="5">
					<tr>
						<td style="width:125px;">
							Codec
						</td>
						<td style="width:75px;">
							Encode
						</td>
						<td style="width:75px;">
							Decode
						</td>
					</tr>';
		
// 	loop and check availability
	foreach ($subtitle_codecs as $codec)
	{
		echo ' 		<tr>
						<td style="border-bottom:1px solid #ccc">
							'.$codec.'
						</td>
						<td style="border-bottom:1px solid #ccc">
							'.(PHPVideoToolkit::canCodecBeEncoded('subtitle', $codec) ? 'YES' : '&nbsp;').'
						</td>
						<td style="border-bottom:1px solid #ccc">
							'.(PHPVideoToolkit::canCodecBeDecoded('subtitle', $codec) ? 'YES' : '&nbsp;').'
						</td>
					</tr>';
	}
	echo '		</table>
  			</td>
		</tr>
	</table>';  

	
// 	loop the codecs
	
    echo '</body></html>';
	