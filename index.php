<?php
	session_start();
	if(!isset($_SESSION["username"])){
		header("location:login.php");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Trang quản trị</title>
	<link rel="stylesheet" href="./styleadmin.css">
	<link rel="stylesheet" href="../fontawesome-free-6.2.1-web/css/all.min.css">
	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<h1 class="heading_admin">Trang quản trị</h1>

		<div class="row">

			<!-- phần tìm kiếm -->
			<div class="col-sm-3">
				 <div class="input-group">
			        <input style="margin-top: 0;" type="text" class="form-control" placeholder="Tìm kiếm" id="txtSearch"/>
			        <div class="input-group-btn">
			          <button class="btn btn-primary" type="submit" id="btnSearch">
					  <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
			          </button>
			        </div>
			      </div>    		
    		</div>
    		<!-- kết thúc phần tìm kiếm -->

    		<!-- phần phân trang -->
    		<div class = "col-sm-6">
    			<nav aria-label="Page navigation example" >
				  <ul class="pagination" style="margin:0px; padding-top:0; margin-left:10px;" id="pagination">			    
				    
				   
				  </ul>
				</nav>
    		</div> <!--kết thúc phần phân trang -->

			
	  		<div class="col-sm-2 text-right">
	  			<button id="btnQuestion" class="btn btn-success">Thêm câu hỏi mới</button>
	  		</div>
	  	</div>

		<table class="table table-striped">
		  <thead>
		    <tr>

		      <th scope="col">STT</th>
		      <th scope="col">Câu hỏi</th>
		      <th scope="col"></th>
		    </tr>
		  </thead>
		  <tbody id="questions">     
		  </tbody>
		</table>

		<div class="logout">
		<button id="btnQuestion" class="btn btn-success">


		
		<a href="logout.php" style="font-size: 16px;">đăng xuất 
					
						<?php
						// echo $_SESSION["username"]
						?>
					
				</a>
		</button>
				

	</div>
	</div>



</body>
</html>
<?php include('mdlQuestion.php')?>
<script type="text/javascript">
	var page = 1;
	//trong sự kiện trang được load xong thì gọi tới hàm load ds câu hỏi
	$(document).ready(function(){
		$('#btnSearch').click();
	});

	$('#btnQuestion').click(function(){
		//khi thêm mới mặc định id của câu hỏi là 1 chuỗi trống
		$('#txtQuestionId').val('');

		//set các giá trị mặc định cho các input khi thêm mới
		$('#txaQuestion').val('');
		$('#txaOptionA').val('');
		$('#txaOptionB').val('');
		$('#txaOptionC').val('');
		$('#txaOptionD').val('');

		//reset lại giá trị cho các radio button 
        $('#rdOptionA').prop('checked',false);
        $('#rdOptionB').prop('checked',false);
        $('#rdOptionC').prop('checked',false);
        $('#rdOptionD').prop('checked',false);



		$('#modalQuestion').modal();
	});

	$('#btnSearch').click(function(){
		let search = $('#txtSearch').val().trim();
		ReadData(search);
		Pagination(search);
	});

	
//sự kiện update câu hỏi
$(document).on('click',"input[name='update']",function(){

var trid = $(this).closest('tr').attr('id');
GetDetail(trid);

$('#txaQuestion').attr('readonly',false);
$('#txaOptionA').attr('readonly',false);
$('#txaOptionB').attr('readonly',false);
$('#txaOptionC').attr('readonly',false);
$('#txaOptionD').attr('readonly',false);

$('#rdOptionA').attr('disabled',false);
$('#rdOptionB').attr('disabled',false);
$('#rdOptionC').attr('disabled',false);
$('#rdOptionD').attr('disabled',false);

$('#txtQuestionId').val(trid);
$('#btnSubmit').show();

});


//sự kiện của button xem chi tiết câu hỏi
	$(document).on('click',"input[name='view']",function() {
		var trid = $(this).closest('tr').attr('id'); // table row ID 	  
		GetDetail(trid);

	   	$('#txaQuestion').attr('readonly','readonly');
		$('#txaOptionA').attr('readonly','readonly');
		$('#txaOptionB').attr('readonly','readonly');
		$('#txaOptionC').attr('readonly','readonly');
		$('#txaOptionD').attr('readonly','readonly');

		$('#rdOptionA').attr('disabled','readonly');
		$('#rdOptionB').attr('disabled','readonly');
		$('#rdOptionC').attr('disabled','readonly');
		$('#rdOptionD').attr('disabled','readonly');

		$('#btnSubmit').hide();
	});

//sự kiện của button xóa câu hỏi
	$(document).on('click',"input[name='delete']",function() {
		
	    var trid = $(this).closest('tr').attr('id'); // lấy id của dòng đc chọn trên table khi click vào
	 
	   	if(confirm("Bạn chắc chắn muốn xóa câu hỏi này?") == true){
	   		$.ajax({
	   			url:'delete.php',
	   			type:'post',
	   			data:{
	   				id:trid
	   			},
	   			success:function(data){
	   				alert(data);
	   				ReadData(search);
	   			}
	   		});

	   	}
  
	});

//hàm load thông tin câu hỏi dựa vào id
	function GetDetail(id){//hàm lấy câu hỏi dựa vào id câu hỏi
		
	   $.ajax({
	   		url:'detail.php',
	   		type:'get',
	   		data:{
	   			id:id
	   		},
	   		success:function(data){
	   			
				var q = jQuery.parseJSON( data);
				$('#txaQuestion').val(q['question']);	
				$('#txaOptionA').val(q['option_a']);
				$('#txaOptionB').val(q['option_b']);
				$('#txaOptionC').val(q['option_c']);
				$('#txaOptionD').val(q['option_d']);

				$('#modalQuestion').modal();//hiện modal có id là modalQuestion

	   			switch(q['answer']){
	   				case 'A':
	   					$('#rdOptionA').prop('checked',true);
   						break;
   					case 'B':
	   					$('#rdOptionB').prop('checked',true);
	   					break;
   					case 'C':
	   					$('#rdOptionC').prop('checked',true);
	   					break;
   					case 'D':
	   					$('#rdOptionD').prop('checked',true);
	   					break;
	   			}
	   		}

	   });
	}

//hàm load ds câu hỏi
	function ReadData(search){
		$.ajax({
			url:'view.php',
			type:'get',
			data:{
				search:search,
				page:page
			},
			success:function(data){
				$('#questions').empty();
				$('#questions').append(data);
			}
		});
	}

	 $('#txtSearch').on('keypress', function (e) {
         if(e.which === 13){
	           $('#btnSearch').click();
	         }
	   });




	$("#pagination").on("click", "li a", function(event){
		event.preventDefault();
	    page = $(this).text();
	    ReadData($('#txtSearch').val());
	});

	// pagination
	function Pagination(search){
		$.ajax({
				url:'pagination.php',
				type:'get',
				data:{
					search:search
				},
				success:function(data){
					console.log(data);
					if(data<=1){
						$('#pagination').hide();
					}else{
						$('#pagination').show();
						$('#pagination').empty();
						let pagi = '';
						for(i = 1; i<=data; i++){
							pagi += '<li class="page-item" ><a class="page-link" href="#">'+i+'</a></li>';
						}
						$('#pagination').append(pagi);
					}
				}
			});
	}

</script>