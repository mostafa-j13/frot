<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cpatcha
 *
 * @author mostafa
 */
class CaptchaService extends Service{
    //put your code here
    public function show()
    {
        Response::getInstance()->setContent('image/png');
        $str=$this->randomString();
        Session::getInstance()->Captcha=$str;
        $image_x=100;
        $image_y=40;
        $im=imagecreatetruecolor($image_x, $image_y);
        $bgcoolor=imagecolorallocate($im, rand(177, 255), rand(177, 255), rand(177, 255));
        imagefill($im, 0, 0, $bgcoolor);
        
        $cl=imagecolorallocate($im, rand(0, 100), rand(0, 100), rand(0, 100));
	$f=imageloadfont('hadi.gdf');
        imagestring($im, $f, 10, 10, $str, $cl);
	$lineCount=rand(7,12);
        while($lineCount--)
        {
            $cl=imagecolorallocate($im, rand(0, 127), rand(0, 127), rand(0, 127));
            imageline($im, rand(0, $image_x), rand(0, $image_y), rand(0, $image_x), rand(0, $image_y), $cl);
        }
        imagepng($im);
	
    }

    private function randomString()
    {
        $str='';
        $len=rand(5, 8);
        while($len--)
        {
            $type=rand(1,3);
            if($type==1)
            {
                $ch=rand(1,9);
            }
            else if($type==2)
            {
                $ch=chr(0x61+rand(0,25));
            }
            else if($type==3)
            {
                $ch=chr(0x41+rand(0,25));
            }
            $str.=$ch;
        }


        return $str;
    }
}
?>
