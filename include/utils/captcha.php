<?php 
class utils_captcha{
	public 
	//验证码值，字符串
	$value_, 
	//最终验证码图片
	$img_, 
	//图片宽
	$img_w, 
	//图片高
	$img_h, 
	//图片文字颜色
	$char_color, 
	//图片背景颜色
	$bg_color, 
	//字符串长度
	$str_len, 
	//字体放大倍数
	$font_zoom, 
	//最大旋转角度
	$max_rotate_angle, 
	//字符间最大重叠比例，小数，比如一个字符图片的宽带为20像素，重合4像素则为0.2
	$max_overlap, 
	//干扰线x方向最大单步距离
	$disturb_x_step_max, 
	//干扰线y方向最大单步距离
	$disturb_y_step_max, 
	//干扰线最大线宽
	$disturb_line_thick_max, 
	//干扰线断裂的最大周期，如果期待干扰线画10步则断裂1次，则可以将该值设为10
	$disturb_line_null_T;
	
	private $font_size, $font_w, $font_h, $char_frame_w, $char_frame_h;
	
	/**
	 * 构造函数
	 * @param unknown_type $imgW 图像宽
	 * @param unknown_type $imgH 图像高
	 * @param unknown_type $strLen 字符长度
	 * @param unknown_type $fontSize 字体大小 1~5
	 * @param unknown_type $fontZoom 字符放大倍数
	 * @throws Exception
	 */
	public  function __construct($imgW = 100, $imgH = 30, $strLen = 4, $fontSize = 5, $fontZoom = 2){
		if($imgW < 1 || $imgH < 1 || $strLen < 1 || $fontSize < 1 || $fontZoom < 0){
			throw  new Exception("构造函数参数有误，图片宽($imgW)、高($imgH)、字符长度($strLen)、字体大小($fontSize)均不能小于1,
			字体缩放比例($fontZoom)不能为负");
		}
		$this->font_zoom = $fontZoom;
		$this->img_w = $imgW;
		$this->img_h = $imgH;
		$this->str_len = $strLen;
        $this->value_ = self::random_string($this->str_len);
		$this->font_size = $fontSize;
		$this->font_w = imagefontwidth($this->font_size);
		$this->font_h = imagefontheight($this->font_size);
		$this->char_frame_w = $this->font_w * $this->font_zoom;
		$this->char_frame_h = $this->font_h * $this->font_zoom;
		$this->max_rotate_angle = 20;
		$this->max_overlap = 0.3;
		$this->disturb_line_thick_max = 2;
		$this->disturb_x_step_max = 10;
		$this->disturb_y_step_max = 3;
		$this->disturb_line_null_T = 10;
		
		$this->img_ = imagecreatetruecolor($imgW, $imgH);
		$this->bg_color = 0 | (rand(200, 255) << 16) | (rand(200,255) << 8) | rand(200,255);//随机生成背景色
		$this->char_color = 0 | (rand(0, 200) << 16) | (rand(0, 200) << 8) | rand(0, 200);//随机生成字符颜色
		imagefill($this->img_, 0, 0, $this->bg_color);
		$this->drawValue();
		//imageantialias($this->img_, TRUE);
		$this->disturb();
	}
	
	/**
	 * 干扰，画出干扰线
	 * @throws Exception
	 */
	private function disturb(){
		if($this->disturb_x_step_max > $this->img_w / 2 || $this->disturb_y_step_max > $this->img_h / 2){
			throw new Exception("干扰线X、Y方向的最大步伐不能大于图片宽、高的一半");
		}
		//线段起点X
		$curX = rand(0, ($this->img_w - $this->char_frame_w * $this->str_len) / 2);
		//线段起点Y
		$curY = rand($this->img_h * 0.2, $this->img_h * 0.8);
		
		while($curX < $this->img_w){
			//线段终点X
			$nextX = $curX + rand(1, $this->disturb_x_step_max);
			//线段终点Y
			$nextY = $curY + rand(-$this->disturb_y_step_max, $this->disturb_y_step_max);
			if($nextY < 0)
				$nextY += $this->disturb_y_step_max;
			else if($nextY > $this->img_h)
				$nextY -= $this->disturb_y_step_max;
			
			//根据概率使干扰线断裂
			if(rand(1,$this->disturb_line_null_T) != 1){
				self::imagelinethick($this->img_, $curX, $curY, $nextX, $nextY, $this->char_color, rand(1, $this->disturb_line_thick_max));
			}
			$curX = $nextX;
			$curY = $nextY;
		}
	}
	
	/**
	 * 静态方法，画出具有线宽的线段
	 * @param unknown_type $image 图片
	 * @param unknown_type $x1 起点X
	 * @param unknown_type $y1 起点Y
	 * @param unknown_type $x2 终点X
	 * @param unknown_type $y2 终点Y
	 * @param unknown_type $color 颜色
	 * @param unknown_type $thick 线宽
	 */
	static function imagelinethick($image, $x1, $y1, $x2, $y2, $color, $thick = 1)
	{
		/* 下面两行只在线段直角相交时好使
		 imagesetthickness($image, $thick);
		return imageline($image, $x1, $y1, $x2, $y2, $color);
		*/
		if($thick < 1){
			return TRUE;
		}
		if ($thick == 1) {
			return imageline($image, $x1, $y1, $x2, $y2, $color);
		}
		$t = $thick / 2 - 0.5;
		if ($x1 == $x2 || $y1 == $y2) {
			return imagefilledrectangle($image, round(min($x1, $x2) - $t), round(min($y1, $y2) - $t), round(max($x1, $x2) + $t), round(max($y1, $y2) + $t), $color);
		}
		$k = ($y2 - $y1) / ($x2 - $x1); //y = kx + q
		$a = $t / sqrt(1 + pow($k, 2));
		$points = array(
		round($x1 - (1+$k)*$a), round($y1 + (1-$k)*$a),
		round($x1 - (1-$k)*$a), round($y1 - (1+$k)*$a),
		round($x2 + (1+$k)*$a), round($y2 - (1-$k)*$a),
		round($x2 + (1-$k)*$a), round($y2 + (1+$k)*$a),
		);
		imagefilledpolygon($image, $points, 4, $color);
		return imagepolygon($image, $points, 4, $color);
	}
	
	/**
	 * 在html中输出图像
	 */
	public function show(){
		//输出图像
		//header("Content-type:image/JPEG");
		imagejpeg($this->img_);
	}
	
	/**
	 * 在图片中画出字符串
	 */
	private function drawValue(){
		$value_chars = str_split($this->value_, 1);
		$startX = ($this->img_w - $this->char_frame_w * $this->str_len) / 2;
		if($startX < 0)
			$startX = 0;
		$startY = ($this->img_h - $this->char_frame_h) / 2;
		foreach($value_chars as $c){
			$charImg = $this->charToImg($c);
			imagecopyresized($this->img_, $charImg, $startX, $startY, 0, 0, $this->char_frame_w, $this->char_frame_h,
			imagesx($charImg), imagesy($charImg));
			$startX += rand($this->char_frame_w * (1 - $this->max_overlap), $this->char_frame_w * (1 - $this->max_overlap/2));
		}
	}
	
	/**
	 * 将单个字符转换为对应的一张图片,背景透明
	 * @param unknown_type $c
	 */
	private function charToImg($c){
		$bg_color = 0xff000000;//透明背景
		//原字符图片
		$imgOriginal = imagecreatetruecolor($this->font_w, $this->font_h);
		imagesavealpha($imgOriginal, true);
		//缩放后的字符图片
		$imgZoomed = imagecreatetruecolor($this->char_frame_w, $this->char_frame_h);
		imagesavealpha($imgZoomed, true);
		imagefill($imgOriginal, 0, 0, $bg_color);
		imagefill($imgZoomed, 0, 0, $bg_color);
		imagechar($imgOriginal, $this->font_size, 0, 0, $c, $this->char_color);
		imagecopyresized($imgZoomed, $imgOriginal, 0, 0, 0, 0, $this->char_frame_w, $this->char_frame_h, $this->font_w, $this->font_h);
		$angle = rand(-$this->max_rotate_angle, $this->max_rotate_angle);
		//旋转后的字符图片
		$imgRotated = imagerotate($imgZoomed, $angle, imageColorAllocateAlpha($imgZoomed, 0, 0, 0, 127),  0);
		imagesavealpha($imgRotated, true);
		return $imgRotated;
	}
	
	/**
	 * 随机获取指定长度的字符串
	 * @param unknown_type $length
	 * @throws Exception
	 */
	static function random_string($length)
	{
		if (empty($length) || $length < 1)
		{
			throw new Exception("random_string()函数参数($length)不得小于1");
		}
		//字符串源，这样写出来的目的是可以手动去除一些容易歧义的字符，比如具体环境中1与l、6与b很难区分
		$string = '012345789';
		$chars = str_split($string, 1);
		$output = '';
		for ($i=0; $i<$length; $i++)
		{
			$output .= $chars[rand(0, count($chars) - 1)];
		}
		return $output;
	}
	public function getValue() {
		return $this->value_;
	}
	public function getImg() {
		return $this->img_;
	}
}
//$ca = new utils_captcha();
//$ca->show();
