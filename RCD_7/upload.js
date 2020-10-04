var uploadConfigStandard = new Object();
uploadConfigStandard.mime_types = [ 'image/jpeg', 'image/png' ];
uploadConfigStandard.sizeLimit = 1*1024*1024;
uploadConfigStandard.orientation = false;/*portrait,landscape*/
uploadConfigStandard.minRatio = 0;
uploadConfigStandard.maxRatio = 3;
uploadConfigStandard.msgErroRatio = "Escolha uma imagem com tamanho<br>16:9, 4:3 ou 1:1!"; 
uploadConfigStandard.minWidth = 400;
uploadConfigStandard.maxWidth = 2000;
uploadConfigStandard.msgErroMinWidth = "Escolha uma imagem com largura<br>maior ou igual a 400px!";
uploadConfigStandard.msgErroMaxWidth = "Escolha uma imagem com largura<br>menor ou igual a 2000px!";

function newUpload(obj,objLabel,objListaUpload,objPhpFileUpload,uploadConfig,resetList){
	if(typeof uploadConfig === "undefined"){
		uploadConfig = uploadConfigStandard;
	}
	
	try{
		let drop_ = document.getElementById(obj);
		drop_.addEventListener('dragenter', function(){
			document.getElementById(objLabel).classList.add('highlight');
		});
		drop_.addEventListener('dragleave', function(){
			document.getElementById(objLabel).classList.remove('highlight');
		});
		drop_.addEventListener('drop', function(){
			document.getElementById(objLabel).classList.remove('highlight');
		});
	}catch(e){
		alert("#1" + e); /* apaguei esse alert porque estava dando conflito quando o usuario não tem permissão*/
	}

	document.getElementById(obj).addEventListener('change', function() {
		try{
			if(typeof resetList !== "undefined"){
				resetUploadFile(objListaUpload);
			}
			var files = this.files;
			for(var i = 0; i < files.length; i++){
				validarArquivo(files[i],i,obj,objListaUpload,objPhpFileUpload,uploadConfig);
			};
		}catch(e){
			alert("#2" + e);
		}
	});
}

function resetUploadFile(obj){
	if(typeof obj === "undefined"){
		document.querySelector('.lista-uploads').innerHTML = "";
	}else{
		document.getElementById(obj).innerHTML = "";
	}
}

function validarArquivo(file,indice,obj,objListaUpload,objPhpFileUpload,uploadConfig){
	try{		
		// Validar os tipos
		if(uploadConfig.mime_types.indexOf(file.type) == -1) {
			aposValidar({"error" : "O arquivo " + file.name + " não permitido"},indice,obj,objListaUpload,objPhpFileUpload);
		}else if(file.size > uploadConfig.sizeLimit) {
			var limit = ((uploadConfig.sizeLimit / 1024) / 1024);
			aposValidar({"error" : file.name + " ultrapassou limite de " + limit + "MB"},indice,obj,objListaUpload,objPhpFileUpload);
		}else if(file.type.match(/image.*/)){
	        var img = document.createElement('img');
	        // add this into an onload, as it takes time (albeit very little) to load the image into the DOM object
	        img.onload = function(){
	            var width = img.width;
	            var height = img.height;
	            
	            var result = true;
	            var erro;
	            
	            var ratio = (width / height);
	            
	            if(uploadConfig.orientation=="landscape"){
	            	if(ratio<1){
	            		erro = {"error" : "Escolha uma imagem em formato de paisagem!"};
	            		result = false;
	            	}
	            }else if(uploadConfig.orientation=="portrait"){
	            	if(ratio>=1){
	            		erro = {"error" : "Escolha uma imagem em formato de retrato!"};
	            		result = false;
	            	}
	            }
	            
	            if(uploadConfig.minRatio!=false && uploadConfig.maxRatio!=false){
	            	if(ratio<uploadConfig.minRatio || ratio>uploadConfig.maxRatio){
	            		erro = {"error" : uploadConfig.msgErroRatio};
	            		result = false;
	            	}
	            }
	            
	            if(uploadConfig.minWidth!=false){
	            	if(width<uploadConfig.minWidth){
	            		erro = {"error" : uploadConfig.msgErroMinWidth};
	            		result = false;
	            	}
	            }
	            
	            if(uploadConfig.maxWidth!=false){
	            	if(width>uploadConfig.maxWidth){
	            		erro = {"error" : uploadConfig.msgErroMaxWidth};
	            		result = false;
	            	}
	            }
	            
	            if(result==true){
	            	aposValidar({"success": "Enviando: " + file.name},indice,obj,objListaUpload,objPhpFileUpload);
	            }else{
	            	aposValidar(erro,indice,obj,objListaUpload,objPhpFileUpload);
	            }
	        };
	        // put the file into the img object, triggering the img onload handler above
	        var reader = new FileReader();
	        reader.onload = function(e) {img.src = e.target.result};
	        reader.readAsDataURL(file);
	    }else{
			// Se der tudo certo
			aposValidar({"success": "Enviando: " + file.name},indice,obj,objListaUpload,objPhpFileUpload);
	    }
	}catch(e){
		alert("#3" + e);
	}
}

function aposValidar(info,indice,obj,objListaUpload,objPhpFileUpload){
	try{
		//Criar barra
		var barra = document.createElement("div");
		var fill = document.createElement("div");
		var text = document.createElement("div");
		barra.appendChild(fill);
		barra.appendChild(text);
		
		barra.classList.add("barra");
		fill.classList.add("fillB");
		text.classList.add("textB");
		
		if(info.error == undefined){
			text.innerHTML = info.success;
			enviarArquivo(indice, barra,obj,objPhpFileUpload); //Enviar
		}else{
			text.innerHTML = info.error;
			barra.classList.add("error");
		}
		
		//Adicionar barra
		document.getElementById(objListaUpload).innerHTML = "";
		document.getElementById(objListaUpload).appendChild(barra);
	}catch(e){
		alert("#5" + e);
	}
}

function enviarArquivo(indice, barra,obj,objPhpFileUpload){
	try{
		var data = new FormData();
		var request = new XMLHttpRequest();
		var idobjPhpFileUpload = document.getElementById(objPhpFileUpload);
		
		//Adicionar arquivo
		data.append('file', document.getElementById(obj).files[indice]);
		
		// AJAX request finished
		request.addEventListener('load', function(e) {
			// Resposta
			if(request.response.status == "success"){
				barra.querySelector(".textB").innerHTML = request.response.name;
				barra.classList.add("completeB");
				uploadCompleted(request.response.content);
			}else{
				barra.querySelector(".textB").innerHTML = "Erro ao enviar: " + request.response.name;
				barra.classList.add("error");
			}
		});
		
		// Calcular e mostrar o progresso
		request.upload.addEventListener('progress', function(e) {
			var percent_complete = (e.loaded / e.total)*100;
			
			barra.querySelector(".fillB").style.minWidth = percent_complete + "%";
		});
		
		//Resposta em JSON
		request.responseType = 'json';
		
		// Caminho
		request.open('post', idobjPhpFileUpload.value); 
		request.send(data);
	}catch(e){
		alert("#4" + e);
	}
}