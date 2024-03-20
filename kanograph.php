<?php

abstract class AlignType
{
    const TopRight = 0;
    const TopLeft = 1;
    const Top = 2;
    const Right = 3;
    const Left = 4;
    const BottomRight = 5;
    const BottomLeft = 6;
    const Bottom = 7;
}

function drawMark($x , $y, $text , $align)
{
      $cx=500+5*$x; 
      $cy=500-5*$y;
      $xshift = 0;
      $yshift  = -6;


      $anchor = '';
      if ($align == AlignType::Right || $align == AlignType::TopRight|| $align ==AlignType::BottomRight)
          $anchor = 'start';
      if ($align == AlignType::Left || $align == AlignType::TopLeft || $align== AlignType :: BottomLeft)
          $anchor = 'end';
      if ($align == AlignType::Top || $align == AlignType ::Bottom )
          $anchor = 'middle';

      if ($align == AlignType::Right || $align == AlignType::Left )
      $yshift = +5;
      if ($align == AlignType :: Bottom  || $align == AlignType::BottomRight || $align == AlignType::BottomLeft)
       $yshift = +17;
      if ($align == AlignType :: Top  || $align == AlignType::TopRight || $align == AlignType::TopLeft)
       $yshift = -7;
      if ($align == AlignType::Left)
       $xshift = -10;  
      if ($align == AlignType::Right)
       $xshift = 10;

      $cxx = $cx + $xshift;
      $cyy = $cy + $yshift;

      $rectx = 0;
      $recty = 0;
      $rectw = 600;
      $recth = 14;

      $recty = $cyy - $recth; 
     
      if (($align == AlignType::TopRight) || ($align == AlignType::BottomRight) || ($align == AlignType::Right)) 
          $rectx = $cxx;
       else if (($align == AlignType::TopLeft) || ($align == AlignType::BottomLeft)|| ($align == AlignType::Left))
          $rectx = $cxx - $rectw;
      else if (($align == AlignType::Top)|| ($align == AlignType::Bottom))
          $rectx = $cxx - $rectw/2;
     
        
       $b=array($rectx,$recty,$rectw,$recth);
       array_push($b);        

	    print (	'<circle cx="'.$cx.'"  cy="'.$cy.'" r="6"/>'.
//				'<rect x="'.$rectx.'" y="'.$recty.'" width="'.$rectw.'" height="'.$recth.'" stroke="black" fill="none"  stroke-width="1"/>'.
				'<text font-weight="normal" font-style="normal" text-anchor="'.$anchor.'" font-family="Helvetica, Arial, sans-serif" font-size="14" id="svg6" y="'.$cyy.'" x="'.$cxx.'"  fill="#000000">'.$text.'</text>');
}

function CalcMark($x , $y, $text , $align)
{
      $cx=$x; 
      $cy=$y;
      $xshift = 0;
      $yshift  = -6;


      $anchor = '';
      if ($align == AlignType::Right || $align == AlignType::TopRight|| $align ==AlignType::BottomRight)
          $anchor = 'start';
      if ($align == AlignType::Left || $align == AlignType::TopLeft || $align== AlignType :: BottomLeft)
          $anchor = 'end';

      if ($align == AlignType::Right || $align == AlignType::Left )
       $yshift = +10;
      if ($align == AlignType::BottomRight || $align == AlignType::BottomLeft)
       $yshift = +26;
      if ($align == AlignType::TopRight || $align == AlignType::TopLeft)
       $yshift = -6;
      if ($align == AlignType::Left)
       $xshift = -10;  
      if ($align == AlignType::Right)
       $xshift = 10;

      $cxx = $cx + $xshift;
      $cyy = $cy + $yshift;

      $rectx = 0;
      $recty = 0;
      $rectw = 1000;
      $recth = 14;

      $recty = $cyy - $recth; 
     
      if (($align == AlignType::TopRight) || ($align == AlignType::BottomRight) || ($align == AlignType::Right)) 
          $rectx = $cxx;
       else if (($align == AlignType::TopLeft) || ($align == AlignType::BottomLeft)|| ($align == AlignType::Left))
          $rectx = $cxx - $rectw;

     
        
       
       $b=array($rectx,$recty,$rectw,$recth);
     
       return $b;  


}

function TwoRectangles($x1, $y1, $weigth1, $heigth1, $x2, $y2, $weigth2, $heigth2) 
{ 
	$A = max($x1, $x2); 
	$B = min($x1 + $weigth1, $x2 + $weigth2); 
	$C = max($y1, $y2); 
	$D = min($y1 + $heigth1, $y2 + $heigth2); 

	if( ($A < $B) && ($C < $D)) 
	{ 
		$S = ($B - $A)* ($D - $C); 
	} 
	else 
	{ 
		$S = 0; 
	} 

	return $S; 
} 

function alignRectangle($x1,$y1,$text1,$arr)
{  
    $minnac = 100000000000;
    $vr1pr = 0;
        
    for($i1=0; $i1<=5;$i1++)
    {
        $nac = 0;
        foreach($arr as &$value)
        {
            $x2=$value[0];
            $y2=$value[1];
            $text2=$value[2];
            $i2=$value[3];

            $pr1=CalcMark($x1,$y1,$text1,$i1);
            $pr2=CalcMark($x2,$y2,$text2,$i2);        
            $s=TwoRectangles($pr1[0],$pr1[1],$pr1[2],$pr1[3],$pr2[0],$pr2[1],$pr2[2],$pr2[3]);
            $nac = $nac + $s;
        }

        if ( $nac < $minnac )
        {
            $minnac = $nac;
            $vr1pr=$i1;
        }       
    }    
    
    return $vr1pr;
}

function startImage()
{
    print ( '<svg width="1600" height="1000" xmlns="http://www.w3.org/2000/svg">
<g>  <rect fill="#fff" id="canvas_background" height="402" width="582" y="-1" x="-1"/> </g>
<g>');
}

function drawAxes()
{
    print ( '<line stroke="#000" id="svg1" y2="500" x2="0" y1="500" x1="1000" stroke-width="1"/>
<line stroke="#000" id="svg2" y2="0" x2="500" y1="1000" x1="500" stroke-width="1"/>' ) ;
}

function finishImage()
{
    print ( '</g> </svg>');
}
/*
function composeGraph($arr)
{
  $align = array();
  $i=0;
  
  foreach($arr as $item)
  {
    $align[$i] = AlignType::TopRight;
    $i += 1;
  }

  $i = 0;
  foreach($arr as $item)
  {
    drawMark($item[0], $item[1], $item[2], $align[$i]);
    $i += 1;
  }
}
*/
function composeGraph($arr)
{
    $ready = array();
    $align = 0;
    for($i = 0; $i<count($arr);  $i++ )
    {
        if(array_key_exists($i+1,$arr))
            $align = alignRectangle($arr[$i+1][0],$arr[$i+1][1],$arr[$i+1][2],$ready); 
        array_push($ready,array($arr[$i][0],$arr[$i][1],$arr[$i][2],$align));
    }
    $i = 0;
    
    foreach($ready as $item)
    {
        $bufArr = drawMark($item[0], $item[1], $item[2], $item[3]);
       /* array_push($ready[$i],$bufArr[0]);
        array_push($ready[$i],$bufArr[1]);
        array_push($ready[$i],$bufArr[2]);*/
        //print_r($bufArr);
		
        $i += 1;
    }
   
    return $ready;   
}


?> 