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

	echo '<html><head><link type="text/css" rel="stylesheet" href="../common/styles.css"><script type="text/javascript" charset="utf-8" src="../common/pluginobject/pluginobject.js"></script><script>PO.Options.auto_load_prefix="../common/pluginobject/plugins/";</script><meta name="author" content="Oliver Lillie"></head><body>';
	echo '<a class="backtoexamples" href="../index.php#examples">&larr; Back to examples list</a><br /><br />';
	echo '<strong>This example shows you how to convert video to flash video (flv).</strong><br />';
	echo '<span class="small">&bull; The media player used below is Jeroen Wijering\'s excellent <a href="http://www.jeroenwijering.com/?item=JW_FLV_Media_Player">Flash Media Player</a>. Although bundled with this package the Flash Media Player has a <a href="http://creativecommons.org/licenses/by-nc-sa/2.0/">Creative Commons Attribution-Noncommercial-Share Alike 2.0 Generic</a> license.</span><br />';
	echo '<span class="small">&bull; The media player is embedded using <a href="http://sourceforge.net/projects/pluginobject/">PluginObject</a> to embed the examples. It is distributed under a BSD License.</span><br /><br />';
	
// 	load the examples configuration
	require_once '../example-config.php';
	
// 	require the library
	require_once '../../phpvideotoolkit.'.$use_version.'.php';
	
// 	temp directory
	$tmp_dir = PHPVIDEOTOOLKIT_EXAMPLE_ABSOLUTE_PATH.'working'.DS.'tmp'.DS;
	
//	input movie files
	$files_to_process = array(
		PHPVIDEOTOOLKIT_EXAMPLE_ABSOLUTE_PATH.'working'.DS.'to-be-processed'.DS.'MOV00007.3gp',
		PHPVIDEOTOOLKIT_EXAMPLE_ABSOLUTE_PATH.'working'.DS.'to-be-processed'.DS.'Video000.3gp',
		PHPVIDEOTOOLKIT_EXAMPLE_ABSOLUTE_PATH.'working'.DS.'to-be-processed'.DS.'cat.mpeg'
	);

//	output files dirname has to exist
	$video_output_dir = PHPVIDEOTOOLKIT_EXAMPLE_ABSOLUTE_PATH.'working'.DS.'processed'.DS.'videos'.DS;
	
//	log dir
	$log_dir = PHPVIDEOTOOLKIT_EXAMPLE_ABSOLUTE_PATH.'working'.DS.'logs'.DS;
	
//	bit rate of audio (valid vaues are 16,32,64)
	$bitrate = 64;

//	sampling rate (valid values are 11025, 22050, 44100)
	$samprate = 44100;
	
// 	start PHPVideoToolkit class
	$toolkit = new PHPVideoToolkit($tmp_dir);
	
// 	set PHPVideoToolkit class to run silently
	$toolkit->on_error_die = FALSE;
	
// 	start the timer collection
	$total_process_time = 0;
	
// 	loop through the files to process
	foreach($files_to_process as $key=>$file)
	{
// 		get the filename parts
		$filename = basename($file);
		$filename_minus_ext = substr($filename, 0, strrpos($filename, '.'));
		echo '<strong>Processing '.$filename.'</strong><br />';
		
// 		set the input file
		$ok = $toolkit->setInputFile($file);
// 		check the return value in-case of error
		if(!$ok)
		{
// 			if there was an error then get it 
			echo $toolkit->getLastError()."<br /><br />\r\n";
			$toolkit->reset();
			continue;
		}
		
// 		set the output dimensions
		$toolkit->setVideoOutputDimensions(320, 240);
		
// 		set the video to be converted to flv
		$ok = $toolkit->setFormatToFLV($samprate, $bitrate, true);
// 		check the return value in-case of error as we are validating the codecs
		if(!$ok)
		{
// 			if there was an error then get it 
			echo $toolkit->getLastError()."<br /><br />\r\n";
			$toolkit->reset();
			continue;
		}
		
// 		set the output details and overwrite if nessecary
		$ok = $toolkit->setOutput($video_output_dir, $filename_minus_ext.'.flv', PHPVideoToolkit::OVERWRITE_EXISTING);
// 		check the return value in-case of error
		if(!$ok)
		{
// 			if there was an error then get it 
			echo $toolkit->getLastError()."<br /><br />\r\n";
			$toolkit->reset();
			continue;
		}
		
// 		execute the ffmpeg command using multiple passes and log the calls and ffmpeg results
		$result = $toolkit->execute(true, true);
		
// 		get the last command given
		$command = $toolkit->getLastCommand();
// 		echo $command[0]."<br />\r\n";
// 		echo $command[1]."<br />\r\n";
		
// 		check the return value in-case of error
		if($result !== PHPVideoToolkit::RESULT_OK)
		{
// 			move the log file to the log directory as something has gone wrong
			$toolkit->moveLog($log_dir.$filename_minus_ext.'.log');
// 			if there was an error then get it 
			echo $toolkit->getLastError()."<br /><br />\r\n";
			$toolkit->reset();
			continue;
		}
		
// 		get the process time of the file
		$process_time = $toolkit->getLastProcessTime();
		$total_process_time += $process_time; 
		
		$file = array_shift($toolkit->getLastOutput());
		$filename = basename($file);
		$filename_hash = md5($filename);
		
// 		echo a report to the buffer
		echo 'Video converted in '.$process_time.' seconds... <b>'.$file.'</b><br /><br />
<div id="'.$filename_hash.'"></div>
<script type="text/javascript" charset="utf-8">
	PluginObject.embed("../working/processed/videos/'.$filename.'", {
		width : 320,
		height: 240,
		force_plugin:PluginObject.Plugins.FlashMedia,
		player: "../common/mediaplayer/player.swf",
		force_into_id:"'.$filename_hash.'", 
		overstretch:true,
		params: {
			autoplay: false
		}
	});         
</script><br />'."\r\n";
	
// 		reset 
		$toolkit->reset();
	}
	
	echo ''."\r\n".'The total time taken to process all '.($key+1).' file(s) is : <b>'.$total_process_time.'</b>';
	echo '<br />'."\r\n".'The average time taken to process each file is : <b>'.($total_process_time/($key+1)).'</b>';
    echo '</body></html>';