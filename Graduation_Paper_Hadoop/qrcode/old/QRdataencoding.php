<?PHP
/*
編碼代號
Mode Name			Mode Indicator
Numeric Mode			1
Alphanumeric Mode		2
Byte Mode				4
Kanji Mode				8
ECI Mode				7

qrdata 內容
example : HELLO WORLD
Mode Indicator	 |  Character Count Indicator	| Encoded Data |	Terminator
		  
各個版本編碼 Character Count Indicator長度
Versions 1 through 9
Numeric mode: 10 bits
Alphanumeric mode: 9 bits
Byte mode: 8 bits
Japanese mode: 8 bits

Versions 10 through 26
Numeric mode: 12 bits
Alphanumeric mode: 11 bits
Byte mode: 16
Japanese mode: 10 bits

Versions 27 through 40
Numeric mode: 14 bits
Alphanumeric mode: 13 bits
Byte mode: 16 bits
Japanese mode: 12 bits

*/
	include("ECCcoding.php");
	class QRdataencoding {
		var $qrcode_data_string; 
		var $qrcode_module_size;
		var $qrcode_image_type;
	   function QRsetting ( )
	   {
			$datalen=strlen($this->qrcode_data_string);
			
			if (preg_match("/[^0-9A-Z \$\*\%\+\.\/\:\-]/",$this->qrcode_data_string)!=0)  //選擇編碼模式
				{	/*Byte Mode Encoding */
					$mode=4;				
					$datavalue= & $this->QRByte($this->qrcode_data_string); 
					$qrdata=$this->QRcoding(8,8,$mode,$datalen,$datavalue);
					$qrdata=ECCcoding($qrdata);	
					$this->mark($qrdata);
				}else{	
						/*Alphanumeric Mode Encoding*/
						$mode=2;
						$datavalue=& $this->QRalphanumeric($this->qrcode_data_string);
						$qrdata=$this->QRcoding(11,9,$mode,$datalen,$datavalue);
						$qrdata=ECCcoding($qrdata);	
						$this->mark($qrdata);	
					 }
			
			
	}
	function & QRByte($data_string)
	{
		$datalen=strlen($data_string);
		$i=0;
		while ($i<$datalen){
			  $datavalue[$i]=ord(substr($data_string,$i,1));
			  $i++;
			  }
			return $datavalue ;
	}
	function & QRAlphanumeric($data_string)
	{			
						$qrcode_alphanumeric=array("0"=>0,"1"=>1,"2"=>2,"3"=>3,"4"=>4,
						"5"=>5,"6"=>6,"7"=>7,"8"=>8,"9"=>9,"A"=>10,"B"=>11,"C"=>12,"D"=>13,"E"=>14,
						"F"=>15,"G"=>16,"H"=>17,"I"=>18,"J"=>19,"K"=>20,"L"=>21,"M"=>22,"N"=>23,
						"O"=>24,"P"=>25,"Q"=>26,"R"=>27,"S"=>28,"T"=>29,"U"=>30,"V"=>31,
						"W"=>32,"X"=>33,"Y"=>34,"Z"=>35," "=>36,"$"=>37,"%"=>38,"*"=>39,
						"+"=>40,"-"=>41,"."=>42,"/"=>43,":"=>44);
						$this->qrcode_data_string=rawurldecode($this->qrcode_data_string);
						$datalen=strlen($data_string);
						for($i=0;$i<$datalen;$i=$i+2)
						{	
							if( substr($data_string,$i+1,1)=="" )
							{
							$datavalue[$i]=$qrcode_alphanumeric[substr($data_string,$i,1)];
							}
						else{
						$datavalue[$i]=($qrcode_alphanumeric[substr($data_string,$i,1)]*45)+$qrcode_alphanumeric[substr($data_string,$i+1,1)];
							}
						}
						return $datavalue; 
	}			
	
	function QRcoding($modelength,$bit,$mode,$datalen,$datavalue)
	{	/*Mode Indicator*/
		$modebit=DecBin($mode);
		for($i=0 ;$i<4 ; $i++)
		{	
			if(substr($modebit,$i,1)==""){$modebit='0'.$modebit;}
		}
		/*Character Count Indicator */

		$lenbit=DecBin($datalen);
		for($i=0 ;$i<$bit ; $i++)
		{
			if(substr($lenbit,$i,1)==""){$lenbit='0'.$lenbit;}
		}
		/*Encoded Data */
		$datastring="";
		foreach($datavalue as $datarry)
		{	
		
			$databit=DecBin($datarry);
			if($mode==2)if($datarry <=44){$modelength=6;}
			for($i=0 ;$i<$modelength ; $i++)
			{	
			if(substr($databit,$i,1)==""){	$databit='0'.$databit;}
			}
			$datastring=$datastring.$databit ;
		}
		
		/* Terminator*/
		$qrcdoedata=$modebit.$lenbit.$datastring;
		$terminator_bit=(8-(strlen($qrcdoedata)%8));
		$maxlen=(864-(strlen($qrcdoedata)+$terminator_bit))/8 ; //設定version=5 ecc=L 共864bit
		for($i=0 ;$i<$terminator_bit ; $i++)
			{	
				$qrcdoedata=$qrcdoedata.'0';
			}
		for($i=1 ;$i<=$maxlen ; $i++)
			{	
				if( ($i%2)!=0){	$qrcdoedata=$qrcdoedata.'11101100';}
				else{$qrcdoedata=$qrcdoedata.'00010001';}
			}	
				return $qrcdoedata;
	}	
function mark($codewords)
		{	
			/* ------ setting area ------ */
			$path="./data";          					 /* You must set path to data files. */
			$image_path="./image";   					 /* You must set path to QRcode frame images. */
			$version_ul=40;             					 /* upper limit for version  */  
			$qrcode_error_correct='L';  					 /* you must set Ecc */
			$qrcode_module_size=$this->qrcode_module_size;	 /* you must set size number */
			$qrcode_version=5;								 /* you must set version  */			 	
			$qrcode_image_type="jpeg";						 /* you must set image type jpeg and png  */	
			/* ------ setting area end ------ */
					if ($qrcode_module_size>0) {
					} else {
						if ($qrcode_image_type=="jpeg"){
							$qrcode_module_size=4;
						} else {
							$qrcode_module_size=4;
						}
					}
					$ecc_character_hash=array("L"=>"1",
					"l"=>"1",
					"M"=>"0",
					"m"=>"0",
					"Q"=>"3",
					"q"=>"3",
					"H"=>"2",
					"h"=>"2");
					$ec=@$ecc_character_hash[$qrcode_error_correct]; 
					$max_codewords_array=array(0,26,44,70,100,134,172,196,242,
					292,346,404,466,532,581,655,733,815,901,991,1085,1156,
					1258,1364,1474,1588,1706,1828,1921,2051,2185,2323,2465,
					2611,2761,2876,3034,3196,3362,3532,3706);

					$max_codewords=$max_codewords_array[$qrcode_version];
					$max_modules_1side=17+($qrcode_version <<2);

					$matrix_remain_bit=array(0,0,7,7,7,7,7,0,0,0,0,0,0,0,3,3,3,3,3,3,3,
					4,4,4,4,4,4,4,3,3,3,3,3,3,3,0,0,0,0,0,0);

					/* ---- read version ECC data file */
			
					$byte_num=$matrix_remain_bit[$qrcode_version]+($max_codewords << 3);
					$filename=$path."/qrv".$qrcode_version."_".$ec.".dat";
					$fp1 = fopen ($filename, "rb");
						$matx=fread($fp1,$byte_num);
						$maty=fread($fp1,$byte_num);
						$masks=fread($fp1,$byte_num);
						$fi_x=fread($fp1,15);
						$fi_y=fread($fp1,15);
						$rso=fread($fp1,128);
					fclose($fp1);

					$matrix_x_array=unpack("C*",$matx);
					$matrix_y_array=unpack("C*",$maty);
					$mask_array=unpack("C*",$masks);
					$rs_block_order=unpack("C*",$rso);
					$format_information_x2=unpack("C*",$fi_x);
					$format_information_y2=unpack("C*",$fi_y);
					$format_information_x1=array(0,1,2,3,4,5,7,8,8,8,8,8,8,8,8);
					$format_information_y1=array(8,8,8,8,8,8,8,8,7,5,4,3,2,1,0);
						/* ---- flash matrix */
					$i=0;
					while ($i<$max_modules_1side){
						$j=0;
						while ($j<$max_modules_1side){
							$matrix_content[$j][$i]=0;
							$j++;
						}
						$i++;
					}
							
					/* --- attach data */

					$i=0;
					while ($i<$max_codewords){
						$codeword_i=$codewords[$i];
						$j=8;
						while ($j>=1){
							$codeword_bits_number=($i << 3) +  $j;
							$matrix_content[ $matrix_x_array[$codeword_bits_number] ][ $matrix_y_array[$codeword_bits_number] ]=((255*($codeword_i & 1)) ^ $mask_array[$codeword_bits_number] ); 
							$codeword_i= $codeword_i >> 1;
							$j--;
						}
						$i++;
					}

					$matrix_remain=$matrix_remain_bit[$qrcode_version];
					while ($matrix_remain){
						$remain_bit_temp = $matrix_remain + ( $max_codewords <<3);
						$matrix_content[ $matrix_x_array[$remain_bit_temp] ][ $matrix_y_array[$remain_bit_temp] ]  =  ( 0 ^ $mask_array[$remain_bit_temp] );
						$matrix_remain--;
					}

					#--- mask select

					$min_demerit_score=0;
						$hor_master="";
						$ver_master="";
						$k=0;
						while($k<$max_modules_1side){
							$l=0;
							while($l<$max_modules_1side){
								$hor_master=$hor_master.chr($matrix_content[$l][$k]);
								$ver_master=$ver_master.chr($matrix_content[$k][$l]);
								$l++;
							}
							$k++;
						}
					$i=0;
					$all_matrix=$max_modules_1side * $max_modules_1side; 
					while ($i<8){
						$demerit_n1=0;
						$ptn_temp=array();
						$bit= 1<< $i;
						$bit_r=(~$bit)&255;
						$bit_mask=str_repeat(chr($bit),$all_matrix);
						$hor = $hor_master & $bit_mask;
						$ver = $ver_master & $bit_mask;

						$ver_shift1=$ver.str_repeat(chr(170),$max_modules_1side);
						$ver_shift2=str_repeat(chr(170),$max_modules_1side).$ver;
						$ver_shift1_0=$ver.str_repeat(chr(0),$max_modules_1side);
						$ver_shift2_0=str_repeat(chr(0),$max_modules_1side).$ver;
						$ver_or=chunk_split(~($ver_shift1 | $ver_shift2),$max_modules_1side,chr(170));
						$ver_and=chunk_split(~($ver_shift1_0 & $ver_shift2_0),$max_modules_1side,chr(170));

						$hor=chunk_split(~$hor,$max_modules_1side,chr(170));
						$ver=chunk_split(~$ver,$max_modules_1side,chr(170));
						$hor=$hor.chr(170).$ver;

						$n1_search="/".str_repeat(chr(255),5)."+|".str_repeat(chr($bit_r),5)."+/";
						$n3_search=chr($bit_r).chr(255).chr($bit_r).chr($bit_r).chr($bit_r).chr(255).chr($bit_r);

					   $demerit_n3=substr_count($hor,$n3_search)*40;
					   $demerit_n4=floor(abs(( (100* (substr_count($ver,chr($bit_r))/($byte_num)) )-50)/5))*10;


					   $n2_search1="/".chr($bit_r).chr($bit_r)."+/";
					   $n2_search2="/".chr(255).chr(255)."+/";
					   $demerit_n2=0;
					   preg_match_all($n2_search1,$ver_and,$ptn_temp);
					   foreach($ptn_temp[0] as $str_temp){
						   $demerit_n2+=(strlen($str_temp)-1);
					   }
					   $ptn_temp=array();
					   preg_match_all($n2_search2,$ver_or,$ptn_temp);
					   foreach($ptn_temp[0] as $str_temp){
						   $demerit_n2+=(strlen($str_temp)-1);
					   }
					   $demerit_n2*=3;
					  
					   $ptn_temp=array();

					   preg_match_all($n1_search,$hor,$ptn_temp);
					   foreach($ptn_temp[0] as $str_temp){
						   $demerit_n1+=(strlen($str_temp)-2);
					   }

					   $demerit_score=$demerit_n1+$demerit_n2+$demerit_n3+$demerit_n4;

					   if ($demerit_score<=$min_demerit_score || $i==0){
							$mask_number=$i;
							$min_demerit_score=$demerit_score;
					   }

					$i++;
					}

					$mask_content=1 << $mask_number;

					# --- format information

					$format_information_value=(($ec << 3) | $mask_number);
					$format_information_array=array("101010000010010","101000100100101",
					"101111001111100","101101101001011","100010111111001","100000011001110",
					"100111110010111","100101010100000","111011111000100","111001011110011",
					"111110110101010","111100010011101","110011000101111","110001100011000",
					"110110001000001","110100101110110","001011010001001","001001110111110",
					"001110011100111","001100111010000","000011101100010","000001001010101",
					"000110100001100","000100000111011","011010101011111","011000001101000",
					"011111100110001","011101000000110","010010010110100","010000110000011",
					"010111011011010","010101111101101");
					$i=0;
					while ($i<15){
						$content=substr($format_information_array[$format_information_value],$i,1);

						$matrix_content[$format_information_x1[$i]][$format_information_y1[$i]]=$content * 255;
						$matrix_content[$format_information_x2[$i+1]][$format_information_y2[$i+1]]=$content * 255;
						$i++;
					}


					$mib=$max_modules_1side+8;
					$qrcode_image_size=$mib*$qrcode_module_size;
					if ($qrcode_image_size>1480){
					  trigger_error("QRcode : Too large image size",E_USER_ERROR);
					}
					$output_image =ImageCreate($qrcode_image_size,$qrcode_image_size);

					$image_path=$image_path."/qrv".$qrcode_version.".png";

					$base_image=ImageCreateFromPNG($image_path);

					$col[1]=ImageColorAllocate($base_image,0,0,0);
					$col[0]=ImageColorAllocate($base_image,255,255,255);

					$i=4;
					$mxe=4+$max_modules_1side;
					$ii=0;
					while ($i<$mxe){
						$j=4;
						$jj=0;
						while ($j<$mxe){
							if ($matrix_content[$ii][$jj] & $mask_content){
								ImageSetPixel($base_image,$i,$j,$col[1]); 
							}
							$j++;
							$jj++;
						}
						$i++;
						$ii++;
					}
					/*
					#--- output image
					#*/
					$imgfilename=md5($this->qrcode_data_string);
					Header("Content-type: image/".$qrcode_image_type);
					ImageCopyResized($output_image,$base_image,0,0,0,0,$qrcode_image_size,$qrcode_image_size,$mib,$mib);
					imagejpeg($output_image, "./QRimg/".$imgfilename.".jpg");
					ImageJpeg($output_image);
		
}
	

}

?>