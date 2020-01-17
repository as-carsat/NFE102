<?php 
header ('Content-Type: application/json');

$success = false;
$data = array();

include 'include/connection.php';

function response_json($success, $data, $msgErreur=NULL){
	
	$array['success']=$success;
	$array['msg']=$msgErreur;
	$array['result']=$data;
	
	echo json_encode($data);
}

?>

				
				
		<!-- <script type="text/javascript">

					function getEmail(){
					
						$.getJSON('http://localhost/e-commerce/admin/client.php',
							function(json){
							console.log(json);
							console.log(json['results']['email']);
							
							$('#test').php('');
							$each(json['results']['email'], function(index, value){
							
							$('#test').append('<p>'+value['email']+'</p>');
							
							});
					});
					}
						</script>
						 -->


				
				
			