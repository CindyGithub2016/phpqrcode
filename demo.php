<?php
require_once("qrlib.php");

// 图片名, 默认为false，直接输出
$fileName = 'qr.jpg';
// 纠错级别：L、M、Q、H      
$level    = QR_ECLEVEL_L;   
// size, 默认为3
$size     = 5;
// margin, 默认为4
$margin   = 4;

// qr.jpg图片生成到根目录
QRcode::png('哈哈！刷上了就赶紧收藏点赞·', $fileName, $level, $size, $margin);

// display根目录下的qr.jpg
//echo '<img src="' . $fileName . '" />';die;

$logo = 'C:\\Users\\Administrator\\Desktop\\file\\4.jpg';

// 上一步类QRcode的png方法中二维码已经生成并且保存在根目录，直接用$fileName就代表其图片路径
$qr   = imagecreatefromstring(file_get_contents($fileName));    
$logo = imagecreatefromstring(file_get_contents($logo));

if($logo && $qr) {
	$qrWidth      = imagesx($qr);    
	$qrHeight     = imagesy($qr);
	$logoWidth    = imagesx($logo);
	$logoHeight   = imagesy($logo);
	
	$logoQrWidth  = $qrWidth / 9;    
	$scale = $logoWidth / $logoQrWidth;    
	$logoQrHeight = $logoHeight / $scale;
	
	// 使logo居中
	$fromWidth  = ($qrWidth - $logoQrWidth) / 2;
	$fromHeight = ($qrHeight - $logoQrHeight) / 2;
	// 组合图片  
	imagecopyresampled($qr, $logo, $fromWidth, $fromHeight, 0, 0, $logoQrWidth, $logoQrHeight, $logoWidth, $logoHeight);
	
	header("Content-type: image/jpg");
	// 直接输出图像流
	imagejpeg($qr);
}