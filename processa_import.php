<?php

	include_once("conexao.php");
	
	//$dados = $_FILES['arquivo'];
	//var_dump($dados);
	
	if(!empty($_FILES['arquivo']['tmp_name'])){
		$arquivo = new DomDocument();
		$arquivo->load($_FILES['arquivo']['tmp_name']);
		//var_dump($arquivo);
		
		$linhas = $arquivo->getElementsByTagName("Row");
		//var_dump($linhas);
		
		$primeira_linha = true;
		$a=0;
		$n=0;
		
		foreach($linhas as $linha){
			if($primeira_linha == false){
				$ra = $linha->getElementsByTagName("Data")->item(0)->nodeValue;
				$nome = $linha->getElementsByTagName("Data")->item(1)->nodeValue;
				$email = $linha->getElementsByTagName("Data")->item(2)->nodeValue;
				
				$result_usuario_selec = "SELECT nome, ra FROM usuarios WHERE ra=:ra";
				$resultado_usuario_selec = $conn->prepare($result_usuario_selec);
				$resultado_usuario_selec->bindParam(':ra', $ra);
			$resultado_usuario_selec->execute();
			

		

			$row_usuario = $resultado_usuario_selec->fetch(PDO::FETCH_ASSOC);
     


$ra2=$row_usuario["ra"];


				if($ra==$ra2){

					$result_usuario_up = "UPDATE usuarios SET nome=:nome, email=:email WHERE ra=:ra";
					$resultado_usuario_up = $conn->prepare($result_usuario_up);
					$resultado_usuario_up->bindParam(':ra', $ra);
					$resultado_usuario_up->bindParam(':nome', $nome);
					$resultado_usuario_up->bindParam(':email', $email);
					$resultado_usuario_up->execute();
					
					
					
					echo "Usuários atualizados <br>";

				echo "RA: $ra <br>";
				echo "Nome: $nome <br>";
				echo "E-mail: $email <br>";
				echo "<hr>";
	$a++;

	

				}else{
				//Inserir o usuário no BD
				$result_usuario = "INSERT INTO usuarios (ra,nome, email) VALUES (:ra,:nome, :email)";
				$resultado_usuario = $conn->prepare($result_usuario);
				$resultado_usuario->bindParam(':ra', $ra);
				$resultado_usuario->bindParam(':nome', $nome);
				$resultado_usuario->bindParam(':email', $email);
				
				$resultado_usuario->execute();
				$n++;

				
				if($resultado_usuario->rowCount()>0){

				echo "Usuários Novos <br>";

			
				echo "RA: $ra <br>";
				echo "Nome: $nome <br>";
				echo "E-mail: $email <br>";
				echo "<hr>";

			}
			
				}

			

				
							}
							
			$primeira_linha = false;
		}
		echo"Total Verificados = ".$a."<br>";
		echo"Total Novos Registros = ".$n."<br>";

	}

?>