<?php
function rupee($num)
{
	$fmt = new NumberFormatter( 'en_IN', NumberFormatter::CURRENCY );
	numfmt_set_pattern($fmt, "##,##,##,##,##,##,##,###.##");
	$thecash = numfmt_format($fmt, $num);

	return $thecash;
}
/*
function rupee($num) 
{
	$thecash = number_format($num);

	return $thecash;
}
*/
function rupees($num)
{
	$num = floatval($num);
	$thecash = number_format($num, 2, '.', ',');

	return $thecash;
}

$words = array('0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'forty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninety','100' => 'hundred ','1000' => 'thousand','100000' => 'lakh','10000000' => 'crore');

function no_to_words($no)
{    
	global $words;
    if($no == 0)
    {
        return ' ';
    }
    else 
    {           
		$novalue=''; $highno=$no; $remainno=0; $value=100; $value1=1000;       
        while($no>=100)    
        {
                if(($value <= $no) &&($no  < $value1))    
                {
					$novalue=$words["$value"];
					$highno = (int)($no/$value);
					$remainno = $no % $value;
					break;
                }
                $value= $value1;
                $value1 = $value * 100;
        }       
        if(array_key_exists("$highno",$words))
        {
            return $words["$highno"]." ".$novalue." ".no_to_words($remainno);
        }
        else 
        {
             $unit=$highno%10;
             $ten =(int)($highno/10)*10;            
             return $words["$ten"]." ".$words["$unit"]." ".$novalue." ".no_to_words($remainno);
         }
    }
}

function Rupees_Words($no)
{  
	$intpart = floor( $no );    // results in 3
	$fraction = $no - $intpart; // results in 0.75	
	$fraction = $fraction * 100; // Paise
	
	if ($fraction > 0)
	{
		$amt = no_to_words($no);
		$paise = no_to_words($fraction);
		$ret = "Rupees " . ucfirst($amt) . " and Paise " . $paise . " only";
	}
	else
	{
		$amt = no_to_words($no);
		$ret = "Rupees " . ucfirst($amt) . " only";
	}
    return $ret;
}



function convertcash($num)
{
    if(strlen($num)>3)
	{
            $lastthree = substr($num, strlen($num)-3, strlen($num));
            $restunits = substr($num, 0, strlen($num)-3); 
            $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; 

            $expunit = str_split($restunits, 2);
            for($i=0; $i<sizeof($expunit); $i++)
			{
                $explrestunits .= (int)$expunit[$i].",";
            }   

            $thecash = $explrestunits.$lastthree;
    } 
	else 
	{
           $thecash = $convertnum;
    }
   
    return "Rs. " .$thecash. ".00";
} 
?>
