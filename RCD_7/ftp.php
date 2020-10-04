<?php
class ftp extends generic {
	# Propriedades
	private $ftp;
	private $host;
	private $user;
	private $pass;
	private $directory;
	private $directoryLocal;
	private $directoryOriginal;
	private $port;
	private $timeout;
	private $ftpRemoto;
	private $hostRemoto;
	private $userRemoto;
	private $passRemoto;
	private $directoryRemoto;
	private $directoryRemotoOriginal;
	private $portRemoto;
	private $timeoutRemoto;
	private $ftpTemp;
	private $directoryTemp;
	private $msgErro = array();
	private $text = array();
	
	# Construtor
	public function __construct($father,$name,$host,$user,$pass,$directory,$directoryLocal,$port=21,$timeout=90){
		$this->name = $name;
		$this->host = $host;
		$this->user = $user;
		$this->pass = $pass;
		$this->directory = $directory;
		$this->directoryLocal = $directoryLocal;
		$this->directoryOriginal = $this->directory;
		$this->port = $port;
		$this->timeout = $timeout;
		$this->father = $father;
		if($this->father!==false){
			$this->layer = $this->father->getFatherLayer();
			$this->nivel = $this->father->getNivel();
		}
		$this->newObj($this,$this->name,"ftp",$this->father->getName());
	}
	
	# Metodos
	public function close($remoto=false){
		if($remoto===false){
			ftp_close($this->ftp);
		}else{
			ftp_close($this->ftpRemoto);
		}
	}
	
	public function connect($remoto=false){
		if($remoto===false){
			$this->ftp = ftp_connect($this->host,$this->port,$this->timeout);
			$this->ftpTemp = $this->ftp;
			$this->directoryTemp = $this->directory;
			$this->userTemp = $this->user;
			$this->passTemp = $this->pass;
		}else{
			$this->ftpRemoto = ftp_connect($this->hostRemoto,$this->portRemoto,$this->timeoutRemoto);
			$this->ftpTemp = $this->ftpRemoto;
			$this->directoryTemp = $this->directoryRemoto;
			$this->userTemp = $this->userRemoto;
			$this->passTemp = $this->passRemoto;
		}
		if($this->ftpTemp===false){
			$this->setMsgErro("Houve uma falha ao tentar conectar ao servidor FTP!");
			return false;
		}else{
			$res = ftp_login($this->ftpTemp, $this->userTemp, $this->passTemp);
			if($res===false){
				$this->setMsgErro("Houve uma falha ao tentar efetuar o login no servidor FTP!");
				return false;
			}else{
				$res = ftp_pasv($this->ftpTemp, true);
				if($res===false){
					$this->setMsgErro("Houve uma falha ao tentar setar o modo passivo da conexão FTP!");
					return false;
				}else{
					$res = ftp_chdir($this->ftpTemp, $this->directoryTemp);
					#$res = true;
					if($res===false){
						$this->setMsgErro("Diretório não localizado!");
						return false;
					}else{
						return true;
					}
				}
			}
		}
	}
	
	public function delete($fileName){
		$fileNameRemoto = str_replace($this->directory, $this->directoryRemoto, $fileName);
		$this->connect(true);
		$resDelete = ftp_delete($this->ftpRemoto, $fileNameRemoto);
		$this->close(true);
	
		if($resDelete===false){
			$this->setMsgErro("Houve uma falha ao tentar remover o diretorio do servidor FTP! ".$fileName);
			return false;
		}else{
			return true;
		}
	}
	
	public function End(){
		$this->e("<div id=\"base".$this->name."\" name=\"base".$this->name."\" style=\"font-family:'Lucida Console'\">",$this->nivel);
		for($i=0;$i<count($this->text);$i++){
			$this->e($this->text[$i],$this->nivel + 1);
		}
		$this->endObj($this->name);
		$this->e("</div>",$this->nivel);
	}
	
	public function ftpRemoto($hostRemoto,$userRemoto,$passRemoto,$directoryRemoto,$portRemoto=21,$timeoutRemoto=90){
		$this->hostRemoto = $hostRemoto;
		$this->userRemoto = $userRemoto;
		$this->passRemoto = $passRemoto;
		$this->directoryRemoto = $directoryRemoto;
		$this->directoryRemotoOriginal = $this->directoryRemoto;
		$this->portRemoto = $portRemoto;
		$this->timeoutRemoto = $timeoutRemoto;
	}
	
	public function getList($remoto=false){
		if($remoto===false){
			$this->ftpTemp = $this->ftp;
			$this->directoryTemp = $this->directory;
		}else{
			$this->ftpTemp = $this->ftpRemoto;
			$this->directoryTemp = $this->directoryRemoto;
		}
		$buff = @ftp_rawlist($this->ftpTemp, $this->directoryTemp, $recursive);
		$list = array();
		if(count($buff)){
			foreach ($buff as $key => $value){
				$id = count($list);
				$valueA = $value;
				while(strpos($value,"  ")){
					$value = str_replace("  ", " ", $value);
				}
				$arrayTemp = explode(" ", $value);
				foreach ($arrayTemp as $keyB => $valueB){
					if($keyB==0) $list[$id]['permission'] = $valueB;
					if($keyB==1) $list[$id]['number'] = $valueB;
					if($keyB==2) $list[$id]['user'] = $valueB;
					if($keyB==3) $list[$id]['group'] = $valueB;
					if($keyB==4) $list[$id]['size'] = $valueB;
					if($keyB==5) $list[$id]['mouth'] = $this->mesAbbIng[$valueB];
					if($keyB==6) $list[$id]['day'] = $valueB;
					if($keyB==7){
						if(strpos($valueB,":")){
							$list[$id]['year'] = date("Y");
							$list[$id]['time'] = $valueB;
						}else{
							$list[$id]['year'] = $valueB;
							$list[$id]['time'] = "00:00";
						}
						$hour = (substr($list[$id]['time'], 0, 2) * 1);
						$minute = (substr($list[$id]['time'], 3, 2) * 1);
						$timestamp = mktime($hour,$minute,0,$list[$id]['mouth'],$list[$id]['day'],$list[$id]['year']);
						$list[$id]['timestamp'] = $timestamp;
					}
					if($keyB==8){
						if((strpos($valueB,".")===false || strpos($valueB,".")>0) && $valueB!="GENERIC" && $valueB!="TMP"){
							$list[$id]['name'] = $valueB;
							$res = @ftp_chdir($this->ftpTemp, $this->directoryTemp.$valueB);
							if($res===false){
								$list[$id]['type'] = "1";
							}else{
								$list[$id]['type'] = "0";
							}
						}else{
							unset($list[$id]);
						}
					}
				}
			}
		}
		return $list;
	}
	
	public function getMsgErro(){
		$msgFinal = "<br><br>";
		foreach ($this->msgErro as $key => $value){
			$msgFinal .= $value;
		}
		$msgFinal .= "<br>";
		return $msgFinal;
	}
	
	public function getTree($widthInt=1000,$widthOverFlow=800){
		global $PAGENAME;
		global $page;
		
		if($page->session->getSession("SEND_LR",$PAGENAME)){
			$resSend = $this->send($page->session->getSession("SEND_LR",$PAGENAME));
			
			if($resSend===false){
				$this->inSide("<span class=\"msgErro\">Houve uma falha! ".$this->getMsgErro()."</span>");
			}
			
			$page->session->unSetSession("SEND_LR",$PAGENAME);
		}
		
		if($page->session->getSession("MKDIR_LR",$PAGENAME)){
			$resMkdir = $this->mkdir($page->session->getSession("MKDIR_LR",$PAGENAME));
				
			if($resMkdir===false){
				$this->inSide("<span class=\"msgErro\">Houve uma falha! ".$this->getMsgErro()."</span>");
			}
				
			$page->session->unSetSession("MKDIR_LR",$PAGENAME);
		}
		
		if($page->session->getSession("DELETE_LR",$PAGENAME)){
			$resDelete = $this->delete($page->session->getSession("DELETE_LR",$PAGENAME));
		
			if($resDelete===false){
				$this->inSide("<span class=\"msgErro\">Houve uma falha! ".$this->getMsgErro()."</span>");
			}
		
			$page->session->unSetSession("DELETE_LR",$PAGENAME);
		}
		
		if($page->session->getSession("RMDIR_LR",$PAGENAME)){
			$resRmdir = $this->rmdir($page->session->getSession("RMDIR_LR",$PAGENAME));
		
			if($resRmdir===false){
				$this->inSide("<span class=\"msgErro\">Houve uma falha! ".$this->getMsgErro()."</span>");
			}
		
			$page->session->unSetSession("RMDIR_LR",$PAGENAME);
		}
		
		$this->connect();
		
		$porta = 1;
		$posicao = 0;
		$nivel = 0;
		$cont = 0;
		$compare = array();
		$andress = array();
		$andress['0']['andress'] = "0";
		$andress['0']['father'] = "0";
		$andress['0']['position'] = 0;
		$andress['0']['total'] = 0;
		$andress['0']['make'] = 1;
		$andress['0']['dir'] = "";
		$andress['0']['name'] = "";
		$andress['0']['type'] = 0;
		$andress['0']['status'] = 0; // 0 - ESTÁ OK, 1 - DESATUALIZADO
		$andress['1']['andress'] = "1";
		$andress['1']['father'] = "0";
		$andress['1']['position'] = 0;
		$andress['1']['total'] = 0;
		$andress['1']['make'] = 0;
		$andress['1']['dir'] = $this->directory;
		$andress['1']['name'] = "";
		$andress['1']['type'] = 0;
		$andress['1']['status'] = 0;
		$compare[$this->directory]['andress'] = "1";
		$compare[$this->directory]['father'] = "0";
		$compare[$this->directory]['dir'] = $this->directory;
		$compare[$this->directory]['size'] = 0;
		$compare[$this->directory]['timestamp'] = 0;
		$compare[$this->directory]['type'] = 0;
		$compare[$this->directory]['status'] = 1;
		$andressA = "1";
		while($porta && $cont<1000){
			if($andress[$andressA]['type']==0 && $andress[$andressA]['make']==0){
				$andress[$andressA]['make'] = 1;
				$this->directory = $andress[$andressA]['dir'];
				$list = $this->getList();
				$list = $this->arraySortMulti($list, "type", "name");
				$totalList = count($list);
				$andress[$andressA]['total'] = $totalList;
				if($totalList>0){
					$strlen = strlen($totalList);
					$first = false;
					foreach ($list as $key => $value){
						$newAndress = $andressA.".".$this->zeroLeft(($key+1),$strlen);
						$andress[$newAndress]['andress'] = $newAndress;
						$andress[$newAndress]['father'] = $andressA;
						$andress[$newAndress]['position'] = ($key+1);
						$andress[$newAndress]['total'] = 0;
						if($value['type']=="0"){
							$andress[$newAndress]['make'] = 0;
							$andress[$newAndress]['dir'] = $this->directory.$value['name']."/";
							$andress[$newAndress]['name'] = $value['name'];
							$andress[$newAndress]['type'] = 0;
							$andress[$newAndress]['status'] = 0;
						}else{
							$andress[$newAndress]['make'] = 1;
							$andress[$newAndress]['dir'] = $this->directory.$value['name'];
							$andress[$newAndress]['name'] = $value['name']." <span style=\"font-size:10px;\">(".$this->formatNumber(($value['size']/1024),2,"DECIMAL_PT")." KB) ".$this->formatDate($value['timestamp'],"timestamp","abb9")."</span>";
							$andress[$newAndress]['type'] = 1;
							$andress[$newAndress]['status'] = 0;
						}
						$compare[$andress[$newAndress]['dir']]['andress'] = $andress[$newAndress]['andress'];
						$compare[$andress[$newAndress]['dir']]['father'] = $andress[$newAndress]['father'];
						$compare[$andress[$newAndress]['dir']]['dir'] = $andress[$newAndress]['dir'];
						$compare[$andress[$newAndress]['dir']]['size'] = $value['size'];
						$compare[$andress[$newAndress]['dir']]['timestamp'] = $value['timestamp'];
						$compare[$andress[$newAndress]['dir']]['type'] = $andress[$newAndress]['type'];
						$compare[$andress[$newAndress]['dir']]['status'] = 1;
						if($first===false){
							$first = true;
							$nextAndress = $newAndress;
						}
					}
					$andressA = $nextAndress;
				}else if($andress[$andressA]['position']<$andress[$andress[$andressA]['father']]['total']){
					$position = $andress[$andressA]['position'] + 1;
					$strlenB = strlen($andress[$andress[$andressA]['father']]['total']);
					$andressA = $andress[$andressA]['father'].".".$this->zeroLeft($position,$strlenB);
				}else{
					$andressA = $andress[$andressA]['father'];
					if($andressA=="0"){
						$porta = 0;
					}
				}
			}else if($andress[$andressA]['position']<$andress[$andress[$andressA]['father']]['total']){
				$position = $andress[$andressA]['position'] + 1;
				$strlenB = strlen($andress[$andress[$andressA]['father']]['total']);
				$andressA = $andress[$andressA]['father'].".".$this->zeroLeft($position,$strlenB);
			}else{
				$andressA = $andress[$andressA]['father'];
				if($andressA=="0"){
					$porta = 0;
				}
			}
		}
		
		if($this->hostRemoto){
			$this->connect(true);
			$portaRemoto = 1;
			$posicaoRemoto = 0;
			$nivelRemoto = 0;
			$contRemoto = 0;
			$compareRemoto = array();
			$andressRemoto = array();
			$andressRemoto['0']['andress'] = "0";
			$andressRemoto['0']['father'] = "0";
			$andressRemoto['0']['position'] = 0;
			$andressRemoto['0']['total'] = 0;
			$andressRemoto['0']['make'] = 1;
			$andressRemoto['0']['dir'] = "";
			$andressRemoto['0']['name'] = "";
			$andressRemoto['0']['type'] = 0;
			$andressRemoto['0']['status'] = 0; // 0 - ESTÁ OK, 1 - DESATUALIZADO
			$andressRemoto['1']['andress'] = "1";
			$andressRemoto['1']['father'] = "0";
			$andressRemoto['1']['position'] = 0;
			$andressRemoto['1']['total'] = 0;
			$andressRemoto['1']['make'] = 0;
			$andressRemoto['1']['dir'] = $this->directoryRemoto;
			$andressRemoto['1']['name'] = "";
			$andressRemoto['1']['type'] = 0;
			$andressRemoto['1']['status'] = 0;
			$directoryCompare = str_replace($this->directoryRemotoOriginal, $this->directoryOriginal, $this->directoryRemoto);
			$compareRemoto[$directoryCompare]['andress'] = "1";
			$compareRemoto[$directoryCompare]['father'] = "0";
			$compareRemoto[$directoryCompare]['dir'] = $this->directoryRemoto;
			$compareRemoto[$directoryCompare]['size'] = 0;
			$compareRemoto[$directoryCompare]['timestamp'] = 0;
			$compareRemoto[$directoryCompare]['type'] = 0;
			$compareRemoto[$directoryCompare]['status'] = 1;
			$andressRemotoA = "1";
			while($portaRemoto && $contRemoto<1000){
				if($andressRemoto[$andressRemotoA]['type']==0 && $andressRemoto[$andressRemotoA]['make']==0){
					$andressRemoto[$andressRemotoA]['make'] = 1;
					$this->directoryRemoto = $andressRemoto[$andressRemotoA]['dir'];
					$listRemoto = $this->getList(true);
					$listRemoto = $this->arraySortMulti($listRemoto, "type", "name");
					$totalListRemoto = count($listRemoto);
					$andressRemoto[$andressRemotoA]['total'] = $totalListRemoto;
					if($totalListRemoto>0){
						$strlenRemoto = strlen($totalListRemoto);
						$firstRemoto = false;
						foreach ($listRemoto as $keyRemoto => $valueRemoto){
							$newAndressRemoto = $andressRemotoA.".".$this->zeroLeft(($keyRemoto+1),$strlenRemoto);
							$andressRemoto[$newAndressRemoto]['andress'] = $newAndressRemoto;
							$andressRemoto[$newAndressRemoto]['father'] = $andressRemotoA;
							$andressRemoto[$newAndressRemoto]['position'] = ($keyRemoto+1);
							$andressRemoto[$newAndressRemoto]['total'] = 0;
							if($valueRemoto['type']=="0"){
								$andressRemoto[$newAndressRemoto]['make'] = 0;
								$andressRemoto[$newAndressRemoto]['dir'] = $this->directoryRemoto.$valueRemoto['name']."/";
								$andressRemoto[$newAndressRemoto]['name'] = $valueRemoto['name'];
								$andressRemoto[$newAndressRemoto]['type'] = 0;
								$andressRemoto[$newAndressRemoto]['status'] = 0;
							}else{
								$andressRemoto[$newAndressRemoto]['make'] = 1;
								$andressRemoto[$newAndressRemoto]['dir'] = $this->directoryRemoto.$valueRemoto['name'];
								$andressRemoto[$newAndressRemoto]['name'] = $valueRemoto['name']." <span style=\"font-size:10px;\">(".$this->formatNumber(($valueRemoto['size']/1024),2,"DECIMAL_PT")." KB) ".$this->formatDate($valueRemoto['timestamp'],"timestamp","abb9")."</span>";
								$andressRemoto[$newAndressRemoto]['type'] = 1;
								$andressRemoto[$newAndressRemoto]['status'] = 0;
							}
							$directoryCompare = str_replace($this->directoryRemotoOriginal, $this->directoryOriginal, $andressRemoto[$newAndressRemoto]['dir']);
							$compareRemoto[$directoryCompare]['andress'] = $andressRemoto[$newAndressRemoto]['andress'];
							$compareRemoto[$directoryCompare]['father'] = $andressRemoto[$newAndressRemoto]['father'];
							$compareRemoto[$directoryCompare]['dir'] = $andressRemoto[$newAndressRemoto]['dir'];
							$compareRemoto[$directoryCompare]['size'] = $valueRemoto['size'];
							$compareRemoto[$directoryCompare]['timestamp'] = $valueRemoto['timestamp'];
							$compareRemoto[$directoryCompare]['type'] = $andressRemoto[$newAndressRemoto]['type'];
							$compareRemoto[$directoryCompare]['status'] = 1;
							if($firstRemoto===false){
								$firstRemoto = true;
								$nextAndressRemoto = $newAndressRemoto;
							}
						}
						$andressRemotoA = $nextAndressRemoto;
					}else if($andressRemoto[$andressRemotoA]['position']<$andressRemoto[$andressRemoto[$andressRemotoA]['father']]['total']){
						$positionRemoto = $andressRemoto[$andressRemotoA]['position'] + 1;
						$strlenRemotoB = strlen($andressRemoto[$andressRemoto[$andressRemotoA]['father']]['total']);
						$andressRemotoA = $andressRemoto[$andressRemotoA]['father'].".".$this->zeroLeft($positionRemoto,$strlenRemotoB);
					}else{
						$andressRemotoA = $andressRemoto[$andressRemotoA]['father'];
						if($andressRemotoA=="0"){
							$portaRemoto = 0;
						}
					}
				}else if($andressRemoto[$andressRemotoA]['position']<$andressRemoto[$andressRemoto[$andressRemotoA]['father']]['total']){
					$positionRemoto = $andressRemoto[$andressRemotoA]['position'] + 1;
					$strlenRemotoB = strlen($andressRemoto[$andressRemoto[$andressRemotoA]['father']]['total']);
					$andressRemotoA = $andressRemoto[$andressRemotoA]['father'].".".$this->zeroLeft($positionRemoto,$strlenRemotoB);
				}else{
					$andressRemotoA = $andressRemoto[$andressRemotoA]['father'];
					if($andressRemotoA=="0"){
						$portaRemoto = 0;
					}
				}
			}
			
			# COMPARA LOCAL COM REMOTO
			foreach ($compare as $keyB => $valueB){
				if($compare[$keyB]['type']==0 || ($compare[$keyB]['size']==@$compareRemoto[$keyB]['size'] && $compare[$keyB]['timestamp']<=@$compareRemoto[$keyB]['timestamp'])){
					$compare[$keyB]['status'] = 0;
					$compareRemoto[$keyB]['status'] = 0;
				}else{
					$andress[$compare[$keyB]['andress']]['status'] = 1;
					$andressTemp = $compare[$keyB]['andress'];
					$andressFather = false;
					while($andress[$andressTemp]['father']!="1" && $andressFather!=$andress[$andressTemp]['father']){
						$andressFather = $andress[$andressTemp]['father'];
						$andressTemp = $andress[$andressTemp]['father'];
						$andress[$andressTemp]['status'] = 1;
					}
					
					if(isset($compareRemoto[$keyB]['andress'])){
						$andressRemoto[$compareRemoto[$keyB]['andress']]['status'] = 1;
						$andressRemotoTemp = $compareRemoto[$keyB]['andress'];
						$andressRemotoFather = false;
						while($andressRemoto[$andressRemotoTemp]['father']!="1" && $andressRemotoFather!=$andressRemoto[$andressRemotoTemp]['father']){
							$andressRemotoFather = $andressRemoto[$andressRemotoTemp]['father'];
							$andressRemotoTemp = $andressRemoto[$andressRemotoTemp]['father'];
							$andressRemoto[$andressRemotoTemp]['status'] = 1;
						}
					}else{
						$andress[$compare[$keyB]['andress']]['status'] = 2;
						$andressTemp = $compare[$keyB]['andress'];
						$andressFather = false;
						while($andress[$andressTemp]['father']!="1" && $andressFather!=$andress[$andressTemp]['father']){
							$andressFather = $andress[$andressTemp]['father'];
							$andressTemp = $andress[$andressTemp]['father'];
							$andress[$andressTemp]['status'] = 1;
						}
					}
				}
			}
			foreach ($compareRemoto as $keyB => $valueB){
				if(@$compareRemoto[$keyB]['type']==0 || ($compareRemoto[$keyB]['size']==@$compare[$keyB]['size'] && $compareRemoto[$keyB]['timestamp']>=@$compare[$keyB]['timestamp'])){
					$compareRemoto[$keyB]['status'] = 0;
					$compare[$keyB]['status'] = 0;
				}else{
					$andressRemoto[$compareRemoto[$keyB]['andress']]['status'] = 0;
					$andressRemotoTemp = $compareRemoto[$keyB]['andress'];
					$andressRemotoFather = false;
					while($andressRemoto[$andressRemotoTemp]['father']!="1" && $andressRemotoFather!=$andressRemoto[$andressRemotoTemp]['father']){
						$andressRemotoFather = $andressRemoto[$andressRemotoTemp]['father'];
						$andressRemotoTemp = $andressRemoto[$andressRemotoTemp]['father'];
						$andressRemoto[$andressRemotoTemp]['status'] = 0;
					}
						
					if(isset($compare[$keyB]['andress'])){
						$andress[$compare[$keyB]['andress']]['status'] = 1;
						$andressTemp = $compare[$keyB]['andress'];
						$andressFather = false;
						while($andress[$andressTemp]['father']!="1" && $andressFather!=$andress[$andressTemp]['father']){
							$andressFather = $andress[$andressTemp]['father'];
							$andressTemp = $andress[$andressTemp]['father'];
							$andress[$andressTemp]['status'] = 1;
						}
					}else{
						$andressRemoto[$compareRemoto[$keyB]['andress']]['status'] = 2;
						$andressRemotoTemp = $compareRemoto[$keyB]['andress'];
						$andressRemotoFather = false;
						while($andressRemoto[$andressRemotoTemp]['father']!="1" && $andressRemotoFather!=$andressRemoto[$andressRemotoTemp]['father']){
							$andressRemotoFather = $andressRemoto[$andressRemotoTemp]['father'];
							$andressRemotoTemp = $andressRemoto[$andressRemotoTemp]['father'];
							$andressRemoto[$andressRemotoTemp]['status'] = 1;
						}
					}
				}
			}
			# FIM - COMPARA LOCAL COM REMOTO
		}
		
		$this->inSide("<script language=\"javascript\">
			function setVisibleToggerTree(Objeto){
				if(document.getElementById(Objeto).style.display=='block'){
					document.getElementById(Objeto).style.display = 'none';
				}else{
					document.getElementById(Objeto).style.display = 'block';
				}
			}
		</script>
		");
		
		$andress = $this->arraySort($andress, "andress");
		if($this->hostRemoto){
			$andressRemoto = $this->arraySort($andressRemoto, "andress");
		}
		
		$this->inSide("<table width=\"100%\">",$nivel);
		$this->inSide("<tr>",$nivel++);
		
		$this->inSide("<td valign=\"top\"><b>Local</b><br>",$nivel++);
		$this->inSide("<div style=\"width:".$widthOverFlow."px;overflow-x:scroll;\">",$nivel++);
		$this->inSide("<div style=\"width:".$widthInt."px;\">",$nivel++);
		$strlenC = 0;
		$nivel = 0;
		$this->inSide("<ul id=\"1\" style=\"list-style-type:none;display:block;\">",$nivel);
		$andressB = "1";
		$lastAndressIsDir = false;
		foreach ($andress as $key => $value){
			if($value['andress']!="0" && $value['andress']!="1"){
				$open = false;
				$countPointA = substr_count($andressB,".");
				$countPoint = substr_count($value['andress'],".");
				if($countPointA>$countPoint){
					$difCountPoint = $countPointA - $countPoint;
					$andressB = $value['andress'];
					for($i=0;$i<$difCountPoint;$i++){
						$nivel--;
						$this->inSide("</ul>",$nivel);
						$nivel--;
					}
					
					if($value['type']=="0"){
						$lastAndressIsDir = true;
						$open = true;
					}else{
						$lastAndressIsDir = false;
					}
				}else if($countPointA==$countPoint){
					if($lastAndressIsDir===true){
						$lastAndressIsDir = false;
						$nivel--;
						$this->inSide("</ul>",$nivel);
						$nivel--;
					}
				}
				if($value['status']==0){
					$cor = COLOR_GREEN;
				}else if($value['status']==1){
					$cor = COLOR_RED;
				}else{
					$cor = COLOR_ORANGE;
				}
				if($value['type']=="0"){
					$this->inSide("<li id=\"L".$value['andress']."\" style=\"cursor:pointer;color:".$cor.";\">[ <span onClick=\"goToPage('".THIS."','MKDIR_LR','".$value['dir']."','','@".$PAGENAME."','objCoretd0');\">></span> ] <span onClick=\"setVisibleToggerTree('".$value['andress']."');\">".$value['name']."</span></li>",$nivel);
					$nivel++;
				}else{
					$this->inSide("<li id=\"L".$value['andress']."\" style=\"cursor:pointer;color:".$cor.";\">[ <span onClick=\"goToPage('".THIS."','SEND_LR','".$value['dir']."','','@".$PAGENAME."','objCoretd0');\">></span> ] ".$value['name']."</li>",$nivel);
				}
				if($countPointA<=$countPoint || $open===true){
					$andressB = $value['andress'];
					if($value['type']=="0"){
						$lastAndressIsDir = true;
						if($value['father']=="1"){
							$this->inSide("<ul id=\"".$value['andress']."\" style=\"list-style-type:none;display:block;\">",$nivel);
						}else{
							$this->inSide("<ul id=\"".$value['andress']."\" style=\"list-style-type:none;display:block;\">",$nivel);
						}
						$nivel++;
					}else{
						$lastAndressIsDir = false;
					}
				}
			}
		}
		$this->inSide("</ul>",$nivel--);
		$this->inSide("</div>",$nivel--);
		$this->inSide("</div>",$nivel--);
		$this->inSide("</td>",$nivel--);
		
		if($this->hostRemoto){
			$nivel++;
			$this->inSide("<td style=\"width:5px;background-color:".COLOR_DARK_SILVER.";\">",$nivel);
			$this->inSide("</td>",$nivel);
			$this->inSide("<td valign=\"top\"><b>Remoto</b><br>",$nivel++);
			$this->inSide("<div style=\"width:".$widthOverFlow."px;overflow-x:scroll;\">",$nivel++);
			$this->inSide("<div style=\"width:".$widthInt."px;\">",$nivel++);
			$strlenCremoto = 0;
			$this->inSide("<ul id=\"R1\" style=\"list-style-type:none;display:block;\">",$nivel);
			$andressC = "R1";
			$lastAndressIsDir = false;
			foreach ($andressRemoto as $keyRemoto => $valueRemoto){
				if($valueRemoto['andress']!="0" && $valueRemoto['andress']!="1"){
					$openRemoto = false;
					$countPointA = substr_count($andressC,".");
					$countPoint = substr_count($valueRemoto['andress'],".");
					if($countPointA>$countPoint){
						$difCountPoint = $countPointA - $countPoint;
						$andressC = $valueRemoto['andress'];
						for($i=0;$i<$difCountPoint;$i++){
							$nivel--;
							$this->inSide("</ul>",$nivel);
							$nivel--;
						}
							
						if($valueRemoto['type']=="0"){
							$lastAndressIsDir = true;
							$openRemoto = true;
						}else{
							$lastAndressIsDir = false;
						}
					}else if($countPointA==$countPoint){
						if($lastAndressIsDir===true){
							$lastAndressIsDir = false;
							$nivel--;
							$this->inSide("</ul>",$nivel);
							$nivel--;
						}
					}
					if($valueRemoto['status']==0){
						$cor = COLOR_GREEN;
					}else if($valueRemoto['status']==1){
						$cor = COLOR_RED;
					}else{
						$cor = COLOR_ORANGE;
					}
					if($valueRemoto['type']=="0"){
						$this->inSide("<li id=\"RL".$valueRemoto['andress']."\" style=\"cursor:pointer;color:".$cor.";\">[ <span onClick=\"goToPage('".THIS."','RMDIR_LR','".$valueRemoto['dir']."','','@".$PAGENAME."','objCoretd0');\">x</span> ] <span onClick=\"setVisibleToggerTree('R".$valueRemoto['andress']."');\">".$valueRemoto['name']."</span></li>",$nivel);
						$nivel++;
					}else{
						$this->inSide("<li id=\"RL".$valueRemoto['andress']."\" style=\"cursor:pointer;color:".$cor.";\">[ <span onClick=\"goToPage('".THIS."','DELETE_LR','".$valueRemoto['dir']."','','@".$PAGENAME."','objCoretd0');\">x</span> ] ".$valueRemoto['name']."</li>",$nivel);
					}
					if($countPointA<=$countPoint || $openRemoto===true){
						$andressC = $valueRemoto['andress'];
						if($valueRemoto['type']=="0"){
							$lastAndressIsDir = true;
							if($valueRemoto['father']=="1"){
								$this->inSide("<ul id=\"R".$valueRemoto['andress']."\" style=\"list-style-type:none;display:block;\">",$nivel);
							}else{
								$this->inSide("<ul id=\"R".$valueRemoto['andress']."\" style=\"list-style-type:none;display:block;\">",$nivel);
							}
							$nivel++;
						}else{
							$lastAndressIsDir = false;
						}
					}
				}
			}
			$this->inSide("</ul>",$nivel--);
			$this->inSide("</div>",$nivel--);
			$this->inSide("</td>",$nivel--);
		}
		
		$this->inSide("</tr>",$nivel);
		$this->inSide("</table>",$nivel);
	}
	
	public function inSide($text,$tab=0){
		$textTab = "";
		for($i=0;$i<$tab;$i++){
			$textTab .= "    ";
		}
		$this->text[count($this->text)] = $textTab.$text;
	}
	
	public function mkdir($dirName){
		$dirNameRemoto = str_replace($this->directory, $this->directoryRemoto, $dirName);
		$this->connect(true);
		$resMkdir = ftp_mkdir($this->ftpRemoto, $dirNameRemoto);
		$this->close(true);
				
		if($resMkdir===false){
			$this->setMsgErro("Houve uma falha ao tentar criar o diretorio do servidor FTP! ".$dirName);
			return false;
		}else{
			return true;
		}
	}
	
	public function rmdir($dirName){
		$dirNameRemoto = str_replace($this->directory, $this->directoryRemoto, $dirName);
		$this->connect(true);
		$resMkdir = ftp_rmdir($this->ftpRemoto, $dirNameRemoto);
		$this->close(true);
	
		if($resMkdir===false){
			$this->setMsgErro("Houve uma falha ao tentar remover o diretorio do servidor FTP! ".$dirName);
			return false;
		}else{
			return true;
		}
	}
	
	public function send($fileOrDirName,$remoto=false){
		$fileOrDirNameAbb = substr($fileOrDirName,(strrpos($fileOrDirName, "/")+1));
		$this->connect();
		$resGet = ftp_get($this->ftp, $this->directoryLocal.$fileOrDirNameAbb, $fileOrDirName, FTP_BINARY);
		$this->close();
		
		if($resGet===false){
			$this->setMsgErro("Houve uma falha ao tentar efetuar o download do servidor FTP! De ".$this->directoryLocal.$fileOrDirNameAbb." Para ".$fileOrDirName);
			return false;
		}else{
			$fileOrDirNameRemoto = str_replace($this->directory, $this->directoryRemoto, $fileOrDirName);
			$this->connect(true);
			$resPut = ftp_put($this->ftpRemoto, $fileOrDirNameRemoto, $this->directoryLocal.$fileOrDirNameAbb, FTP_BINARY);
			$this->close(true);
			
			if($resPut===false){
				$this->setMsgErro("Houve uma falha ao tentar efetuar o upload do servidor FTP! De ".$this->directoryLocal.$fileOrDirNameAbb." para /PROFIABLE_REMOTO/RCD_7/button.php");
				return false;
			}else{
				$this->setMsgErro("Ok! De ".$this->directoryLocal.$fileOrDirNameAbb." para ".$this->directoryRemoto.$fileOrDirNameAbb);
				return true;
			}
		}
	}
	
	public function setMsgErro($msg){
		$id = count($this->msgErro) + 1;
		$this->msgErro[$id] = "(".$id.") ".$msg."<br>";
	}
}