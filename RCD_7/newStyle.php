<?php
# New Style
class newStyle extends generic {
	/*private $animation_delay;
	private $animation_duration;
	private $animation_name;
	private $animation_iteration_count;
	private $animation_direction;
	private $animation_fill_mode;
	private $animation_timing_function;
	private $backGroundRepeat;
	private $border;
	private $border_style;
	private $border_collapse;
	private $border_color;
	private $border_top;
	private $border_top_style;
	private $border_top_color;
	private $border_bottom;
	private $border_bottom_style;
	private $border_bottom_color;
	private $border_right;
	private $border_right_style;
	private $border_right_color;
	private $border_left;
	private $border_left_style;
	private $border_left_color;
	private $cursor;
	private $line_height;
	private $padding;
	private $padding_left;
	private $padding_right;
	private $padding_bottom;
	private $padding_top;
	private $nameFake;
	private $radius;
	private $radius_top_left;
	private $radius_top_right;
	private $radius_bottom_left;
	private $radius_bottom_right;
	private $typeStyle;
	private $ClassCss = array();
	private $ClassCssNivel = array();
	private $make;
	private $position;
	private $position_image;
	private $left;
	private $top;
	private $bottom;
	private $font_family;
	private $font_size;
	private $font_weight;
	private $font_style;
	private $color;
	private $width;
	private $min_width;
	private $max_width;
	private $height;
	private $min_height;
	private $max_height;
	private $zIndex = false;
	private $backGroundColor;
    private $backGroundImage;
    private $backGround;
	private $display;
    private $float;
    private $right;
    private $margin;
    private $marginLeft;
    private $marginRight;
    private $marginTop;
    private $marginBottom;
    private $backGroundSize;
    private $boxShadow;
    private $opacity;
    private $src;
    private $text_decoration;
    private $text_shadow;
    private $text_align;
    private $webkitPrintColorAdjust;
    private $webkitTransition;
    private $webkitAnimation;
    private $text_transform = false;
    private $outline = false;
    private $keyframe_pisca = false;
    private $whiteSpace;
    private $overflow;
    private $textOverflow;*/
	private $obj = array();
	private $currentObj = false;
	private $styles = array();
    
	function __construct($name){
		$this->name = $name;
	}
	public function newGen($objFather,$objChild,$typeObj){
		$this->currentObj = $objFather->getName();
		$this->obj[$objFather->getName()]['nameFather'] = $objFather->getName();
		$this->obj[$objFather->getName()]['nameChild'] = $objChild;
		$this->obj[$objFather->getName()]['type'] = $typeObj;
		$this->obj[$objFather->getName()]['obj'] = $objFather;
	}
	/*public function setLimitText(){
		$this->make = 1;
		$this->whiteSpace = "nowrap";
		$this->overflow = "hidden";
		$this->textOverflow = "ellipsis";
	}
	public function minWidth($value){
		$this->make = 1;
		$this->min_width = $this->checkValue($value);
	}
	public function maxWidth($value){
		$this->make = 1;
		$this->max_width = $this->checkValue($value);
	}
	public function outline($value){
		$this->make = 1;
		$this->outline = $value;
	}
	public function setUpperCase(){
		$this->make = 1;
		$this->text_transform = true;
	}
	public function unSetUpperCase(){
		$this->make = 1;
		$this->text_transform = "none";
	}
	public function setWebkitPrintColorAdjust($value="exact"){
		$this->make = 1;
		$this->webkitPrintColorAdjust = $value;
	}
	public function webkitTransition($value){
		$this->make = 1;
		$this->webkitTransition = $value;
	}
	public function webkitAnimation($value){
		$this->make = 1;
		$this->webkitAnimation = $value;
	}
	public function animationDelay($value){
		$this->make = 1;
		$this->animation_delay = $value;
	}
	public function animationDuration($value){
		$this->make = 1;
		$this->animation_duration = $value;
	}
	public function animationName($name){
		$this->make = 1;
		$this->animation_name = $name;
	}
	public function animationIterationCount($count="infinite"){
		$this->make = 1;
		$this->animation_iteration_count = $count;
	}
	public function animationDirection($direction="alternate"){
		$this->make = 1;
		$this->animation_direction = $direction;
	}
	public function animationFillMode($mode="none"){
		$this->make = 1;
		$this->animation_fill_mode = $mode;
	}
	public function animationTimingFunction($value){
		$this->make = 1;
		$this->animation_timing_function = " cubic-bezier(".$value.")";
	}
	public function backGroundRepeat($value="no-repeat"){
		$this->make = 1;
		$this->backGroundRepeat = $value;
	}
	public function border($size=1,$style="solid",$color=""){
		$this->make = 1;
		$this->border = $this->checkValue($size);
		$this->border_style = $style;
		$this->border_color = $color;
	}
	public function borderCollapse($value="collapse"){
		$this->make = 1;
		$this->border_collapse = $value;
	}
	public function borderBottom($size=1,$style="solid",$color=""){
		$this->make = 1;
		$this->border_bottom = $this->checkValue($size);
		$this->border_bottom_style = $style;
		$this->border_bottom_color = $color;
	}
	public function borderTop($size=1,$style="solid",$color=""){
		$this->make = 1;
		$this->border_top = $this->checkValue($size);
		$this->border_top_style = $style;
		$this->border_top_color = $color;
	}
	public function borderRight($size=1,$style="solid",$color=""){
		$this->make = 1;
		$this->border_right = $this->checkValue($size);
		$this->border_right_style = $style;
		$this->border_right_color = $color;
	}
	public function borderLeft($size=1,$style="solid",$color=""){
		$this->make = 1;
		$this->border_left = $this->checkValue($size);
		$this->border_left_style = $style;
		$this->border_left_color = $color;
	}
	public function cursor($value="pointer"){
		$this->make = 1;
		$this->cursor = $value;
	}
	public function e($texto,$estrutura = 0,$n = 1){
		$textoN = "";
		for($i=1;$i<=$estrutura;$i++){
        	$textoN .= "    ";                          
    	}     
    	if($n) $texto .= "\n";
		$textoN .= $texto;
		echo $textoN;
	}
	public function lineHeight($value){
		$this->make = 1;
		$this->line_height = $this->checkValue($value);
	}
	public function margin($value){
		$this->make = 1;
		$this->margin = $this->checkValue($value);
	}
	public function marginTop($value){
		$this->make = 1;
		$this->marginTop = $this->checkValue($value);
	}
	public function marginBottom($value){
		$this->make = 1;
		$this->marginBottom = $this->checkValue($value);
	}
	public function marginLeft($value){
		$this->make = 1;
		$this->marginLeft = $this->checkValue($value);
	}
	public function padding($value){
		$this->make = 1;
		$this->padding = $this->checkValue($value);
	}
	public function paddingLeft($value){
		$this->make = 1;
		$this->padding_left = $this->checkValue($value);
	}
	public function paddingRight($value){
		$this->make = 1;
		$this->padding_right = $this->checkValue($value);
	}
	public function paddingBottom($value){
		$this->make = 1;
		$this->padding_bottom = $this->checkValue($value);
	}
	public function paddingTop($value){
		$this->make = 1;
		$this->padding_top = $this->checkValue($value);
	}
    public function setMarginLeft($value){
        $this->make = 1;
        $this->marginLeft = $this->checkValue($value);
    }
	public function setVisible(){
		$this->make = 1;
		$this->display = "block";
	}
	public function setInvisible(){
		$this->make = 1;
		$this->display = "none";
	}
	public function src($url){
		$this->src = "url('".$url."') format('truetype')";
	}
	public function srcMulti($urlMulti){
		$this->src = $urlMulti;
	}
	public function radius($value){
		$this->make = 1;
		$this->radius = $this->checkValue($value);
	}
	public function radiusTopLeft($value){
		$this->make = 1;
		$this->radius_top_left = $this->checkValue($value);
	}
	public function radiusTopRight($value){
		$this->make = 1;
		$this->radius_top_right = $this->checkValue($value);
	}
	public function radiusBottomLeft($value){
		$this->make = 1;
		$this->radius_bottom_left = $this->checkValue($value);
	}
	public function radiusBottomRight($value){
		$this->make = 1;
		$this->radius_bottom_right = $this->checkValue($value);
	}
    public function right($value){
		$this->make = 1;
		$this->right = $this->checkValue($value);
	}
	public function position($value){
		$this->make = 1;
		$this->position = $this->checkValue($value);
	}
	public function opacity($value){
		$this->make = 1;
		$this->opacity = $value;
	}
	public function left($value){
		$this->make = 1;
		$this->left = $this->checkValue($value);
	}
	public function top($value){
		$this->make = 1;
		$this->top = $this->checkValue($value);
	}
	public function bottom($value){
		$this->make = 1;
		$this->bottom = $this->checkValue($value);
	}
	public function fontFamily($value){
		$this->make = 1;
		$this->font_family = $value;
	}
	public function fontSize($value){
		$this->make = 1;
		$this->font_size = $this->checkValue($value);
	}
	public function fontStyle($value){
		$this->make = 1;
		$this->font_style = $value;
	}*/
	public function backGroundColor($value){
		$idStyle = count($this->styles);
		$this->styles[$idStyle]['objChild'] = $this->obj[$this->currentObj]['nameChild'];
		$this->styles[$idStyle]['style'] = "background-color:".$value.";";
	}
	public function float($value="left"){
		$idStyle = count($this->styles);
		$this->styles[$idStyle]['objChild'] = $this->obj[$this->currentObj]['nameChild'];
		$this->styles[$idStyle]['style'] = "float:".$value.";";
	}
	public function fontWeight($value="bold"){
		$idStyle = count($this->styles);
		$this->styles[$idStyle]['objChild'] = $this->obj[$this->currentObj]['nameChild'];
		$this->styles[$idStyle]['style'] = "font-weight:".$value.";";
	}
	public function marginRight($value){
		$value = $this->checkValue($value);
		$idStyle = count($this->styles);
		$this->styles[$idStyle]['objChild'] = $this->obj[$this->currentObj]['nameChild'];
		$this->styles[$idStyle]['style'] = "margin-right:".$value.";";
	}
	public function textAlign($value="left"){
		$idStyle = count($this->styles);
		$this->styles[$idStyle]['objChild'] = $this->obj[$this->currentObj]['nameChild'];
		$this->styles[$idStyle]['style'] = "text-align:".$value.";";
	}
	public function width($value){
		$width = $this->checkValue($value);
		$idStyle = count($this->styles);
		$this->styles[$idStyle]['objChild'] = $this->obj[$this->currentObj]['nameChild'];
		$this->styles[$idStyle]['style'] = "width:".$width.";";		
	}
	/*public function height($value){
		$this->make = 1;
		$this->height = $this->checkValue($value);
	}
	public function minHeight($value){
		$this->make = 1;
		$this->min_height = $this->checkValue($value);
	}
	public function maxHeight($value){
		$this->make = 1;
		$this->max_height = $this->checkValue($value);
	}
	public function setPosition($x,$y,$position="absolute"){
		$this->make = 1;
		$this->position = $position;
		$this->left = $this->checkValue($x);
		$this->top = $this->checkValue($y);
	}
	public function zIndex($value){
		$this->make = 1;
		$this->zIndex = $value;
	}*/
    /*public function backGroundImage($url){
		$this->make = 1;
		$this->backGroundImage = "url('".$url."')";
	}
	public function backGround($url, $positionImage=""){
		$this->make = 1;
		if($positionImage){
			$this->backGround = "url('".$url."') ".$positionImage;
		}else{
			$this->backGround = "url('".$url."')";
		}
	}
	public function color($value){
		$this->make = 1;
		$this->color = $value;
	}
    public function backGroundSize($value){
        $this->make = 1;
        $this->backGroundSize = $value;
    }
    public function boxShadow($x=0,$y=0,$e=0,$rgb=0){
    	$this->make = 1;
    	$this->boxShadow = $this->checkValue($x)." ".$this->checkValue($y)." ".$this->checkValue($e)." ".$rgb;
    }
    public function textDecoration($value="none"){
    	$this->make = 1;
    	$this->text_decoration = $value;
    }
    public function textShadow($x=0,$y=0,$e=0,$rgb=0){
    	$this->make = 1;
    	$this->text_shadow = $this->checkValue($x)." ".$this->checkValue($y)." ".$this->checkValue($e)." ".$rgb;
    }
    public function keyframePisca(){
    	$this->make = 1;
    	$this->keyframe_pisca = true;
    }*/
	private function checkValue($value){
		$res = strpos($value,"px");
		if($res===false && is_numeric($value)){
			return $value."px";
		}else{
			return $value;
		}
	}
	public function getStylesExtended(){
		$obj = $this->obj[$this->currentObj]['obj'];
		if($this->obj[$this->currentObj]['type']=="textBox"){
			foreach ($this->styles as $key => $value){
				if($this->styles[$key]['objChild']==$this->obj[$this->currentObj]['nameChild']){
					$obj->textBox[$this->obj[$this->currentObj]['nameChild']]['styles'] .= $this->styles[$key]['style'];
				}
			}
		}
		if($this->obj[$this->currentObj]['type']=="button"){
			foreach ($this->styles as $key => $value){
				if($this->styles[$key]['objChild']==$this->obj[$this->currentObj]['nameChild']){
					$obj->button[$this->obj[$this->currentObj]['nameChild']]['styles'] .= $this->styles[$key]['style'];
				}
			}
		}
		if($this->obj[$this->currentObj]['type']=="comboBox"){
			foreach ($this->styles as $key => $value){
				if($this->styles[$key]['objChild']==$this->obj[$this->currentObj]['nameChild']){
					$obj->comboBox[$this->obj[$this->currentObj]['nameChild']]['styles'] .= $this->styles[$key]['style'];
				}
			}
		}
	}
	/*public function End(){
		if($this->make==1){
			$contObj = count($this->ClassCss);
			if($this->nameFake){
				$this->ClassCss[$contObj] = $this->typeStyle.$this->nameFake."{";
			}else{
				$this->ClassCss[$contObj] = $this->typeStyle.$this->name."{";
			}
			$this->ClassCssNivel[$contObj] = $this->nivel;
			if($this->animation_delay){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "animation-delay:".$this->animation_delay."s;";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->animation_duration){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "animation-duration:".$this->animation_duration."s;";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->animation_name){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "animation-name:".$this->animation_name.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->animation_iteration_count){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "animation-iteration-count:".$this->animation_iteration_count.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->animation_direction){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "animation-direction:".$this->animation_direction.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->animation_fill_mode){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "animation-fill-mode:".$this->animation_fill_mode.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->animation_timing_function){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "animation-timing-function:".$this->animation_timing_function.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->position){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "position:".$this->position.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->left){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "left:".$this->left.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->right){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "right:".$this->right.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->top){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "top:".$this->top.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->bottom){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "bottom:".$this->bottom.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->font_family){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "font-family:".$this->font_family.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->font_size){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "font-size:".$this->font_size.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->font_weight){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "font-weight:".$this->font_weight.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->font_style){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "font-style:".$this->font_style.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->width){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "width:".$this->width.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->max_width){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "max-width:".$this->max_width.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->min_width){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "min-width:".$this->min_width.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->height){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "height:".$this->height.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->max_height){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "max-height:".$this->max_height.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->min_height){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "min-height:".$this->min_height.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->line_height){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "line-height:".$this->line_height.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->backGroundColor){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "background-color:".$this->backGroundColor.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->backGroundImage){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "background-image:".$this->backGroundImage.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->backGroundRepeat){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "background-repeat:".$this->backGroundRepeat.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->backGround){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "background:".$this->backGround.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->color){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "color:".$this->color.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->display){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "display:".$this->display.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->float){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "float:".$this->float.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->margin){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "margin:".$this->margin.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->marginLeft){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "margin-left:".$this->marginLeft.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->marginRight){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "margin-right:".$this->marginRight.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->marginTop){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "margin-top:".$this->marginTop.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->marginBottom){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "margin-bottom:".$this->marginBottom.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->backGroundSize){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "background-size:".$this->backGroundSize.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->boxShadow){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "box-shadow:".$this->boxShadow.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->text_shadow){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "text-shadow:".$this->text_shadow.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->text_decoration){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "text-decoration:".$this->text_decoration.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->text_align){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "text-align:".$this->text_align.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->border){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "border:".$this->border.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->border_style){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "border-style:".$this->border_style.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->border_collapse){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "border-collapse:".$this->border_collapse.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->border_color){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "border-color:".$this->border_color.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->border_top){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "border-top:".$this->border_top.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->border_top_style){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "border-top-style:".$this->border_top_style.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->border_top_color){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "border-top-color:".$this->border_top_color.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->border_bottom){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "border-bottom:".$this->border_bottom.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->border_bottom_style){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "border-bottom-style:".$this->border_bottom_style.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->border_bottom_color){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "border-bottom-color:".$this->border_bottom_color.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->border_right){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "border-right:".$this->border_right.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->border_right_style){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "border-right-style:".$this->border_right_style.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->border_right_color){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "border-right-color:".$this->border_right_color.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->border_left){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "border-left:".$this->border_left.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->border_left_style){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "border-left-style:".$this->border_left_style.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->border_left_color){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "border-left-color:".$this->border_left_color.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->cursor){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "cursor:".$this->cursor.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->padding){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "padding:".$this->padding.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->padding_left){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "padding-left:".$this->padding_left.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->padding_right){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "padding-right:".$this->padding_right.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->padding_bottom){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "padding-bottom:".$this->padding_bottom.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->padding_top){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "padding-top:".$this->padding_top.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->opacity){ 
            	$contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "opacity:".($this->opacity/100).";";$this->ClassCssNivel[$contObj] = $this->nivel + 1;
            	$contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "-moz-opacity:".($this->opacity/100).";";$this->ClassCssNivel[$contObj] = $this->nivel + 1;
            	$contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "filter:alpha(opacity=".$this->opacity.");";$this->ClassCssNivel[$contObj] = $this->nivel + 1;
			}
			if($this->keyframe_pisca){
				$contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "0% {opacity: 1;}";$this->ClassCssNivel[$contObj] = $this->nivel + 1;
				$contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "50% {opacity: 0.4;}";$this->ClassCssNivel[$contObj] = $this->nivel + 1;
				$contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "100% {opacity: 1;}";$this->ClassCssNivel[$contObj] = $this->nivel + 1;
			}
			if($this->src){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "src:".$this->src.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->radius){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "border-radius:".$this->radius.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->radius_top_left){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "border-top-left-radius:".$this->radius_top_left.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->radius_top_right){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "border-top-right-radius:".$this->radius_top_right.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->radius_bottom_left){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "border-bottom-left-radius:".$this->radius_bottom_left.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
            if($this->radius_bottom_right){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "border-bottom-right-radius:".$this->radius_bottom_right.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->zIndex!==false){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "z-index:".$this->zIndex.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->webkitPrintColorAdjust){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "-webkit-print-color-adjust:".$this->webkitPrintColorAdjust.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->webkitTransition){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "-webkit-transition:".$this->webkitTransition.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->webkitAnimation){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "-webkit-animation:".$this->webkitAnimation.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->text_transform===true){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "text-transform:uppercase;";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->text_transform==="none"){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "text-transform:none;";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->outline!==false){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "outline:".$this->outline.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->whiteSpace){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "white-space:".$this->whiteSpace.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->overflow){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "overflow:".$this->overflow.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			if($this->textOverflow){ $contObj = count($this->ClassCss);$this->ClassCss[$contObj] = "text-overflow:".$this->textOverflow.";";$this->ClassCssNivel[$contObj] = $this->nivel + 1; }
			
			$contObj = count($this->ClassCss);
			$this->ClassCss[$contObj] = "}";
			$this->ClassCssNivel[$contObj] = $this->nivel;
		}
		for($i=0;$i<count($this->ClassCss);$i++){
			$this->e($this->ClassCss[$i],$this->ClassCssNivel[$i]);
		}
	}*/
}