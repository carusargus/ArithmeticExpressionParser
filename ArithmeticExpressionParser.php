<?php

function checkParenthesis($exp)
{
    //-1: end of line
    //-2:  means valid
    //0-...: invalid index
    
    $stack=array();
    for ($i=0;$i<strlen($exp);$i++){
        if ($exp[$i]=='(')
            array_push($stack,'(');
        else if ($exp[$i]==')'){
            if (count($stack)==0)
                return $i;
            $t=array_pop($stack);
        }
    }
    if (count($stack)>0){
        return -1;
    }
    return -2;
}

function myEval($exp)
{
    $invidx=checkParenthesis($exp);
    if ($invidx!=-2){
        
        if ($invidx==-1)
            $m= "Invalid Expression, unexpected end of line";
        else
            $m="Invalid Expression, unexpected character at index ".$invidx;
        
        throw new Exception($m);
    }
    
    
    $sum=0;
    $op='+';
    for ($i=0;$i<strlen($exp);$i++){
        if (is_numeric($exp[$i])){
          if ($op=='+'){
              $sum=$sum+$exp[$i]-'0';
              $op='.';
          }  
          else if ($op=='-'){
              $sum=$sum-$exp[$i]-'0';
              $op='.';
          }
          else {
              $m="Invalid Expression, unexpected character at index ".$i;
              throw new Exception($m);
              //return -999;
          }
        }
        else if ($exp[$i]=='-' || $exp[$i]=='+'){
            if ($op=='.')
                $op=$exp[$i];
            else {
                $m="Invalid Expression, unexpected character at index ".$i;
                throw new Exception($m);
                //return -999;
            }
        }
    }
    if ($op!='.'){
        //echo "unexpected error at the end<br>";
        throw new Exception("Invalid Expression, unexpected end of line");
        //return -999;
    }
    
    return $sum;
}

$inputLine = "";
$indent = "    ";
$filename = 'http://cs5339.cs.utep.edu/longpre/expressions.txt';
$contents = file($filename);
foreach($contents as $line){
	$inputLine = preg_replace('/\s+/', '', $line);
	
    
    
    $output = $inputLine."<br>" ;
    echo $output;
    try{
        echo "Result: ".myEval($inputLine)."<br>";
    }
    catch(Exception $e){
        echo $e->getMessage()."<br>";
    }
    echo "<br>";
}

?>