<div class="modal" tabindex="-1" role="dialog" id="modalQuestion">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="txtQuestionId" value="">
        <label for="" style="font-weight:bold">Câu hỏi</label>

        <div class="form-group">
          <textarea class="form-control" id="txaQuestion" rows="1" placeholder="Câu hỏi"></textarea>
        </div>
        <hr class="clearfix">
        <label for="" style="font-weight:bold">Câu trả lời</label>

        <div class="form-group">
          <textarea class="form-control" id="txaOptionA" rows="1" placeholder="Đáp án A"></textarea>
        </div>

        <div class="form-group">
          <textarea class="form-control" id="txaOptionB" rows="1" placeholder="Đáp án B"></textarea>
        </div>

        <div class="form-group">
          <textarea class="form-control" id="txaOptionC" rows="1" placeholder="Đáp án C"></textarea>
        </div>

        <div class="form-group">
          <textarea class="form-control" id="txaOptionD" rows="1" placeholder="Đáp án D"></textarea>
        </div>

        <hr class="clearfix">
        <div class="form-group">
          <label for="" style="font-weight:bold;margin-bottom:10px">Đáp án đúng</label>
           <div class="row">

              <div style="margin-top:-4px" class="radio col-md-3 col-sm-6 ">
                <label><input type="radio" name="optradio" id="rdOptionA">Đáp án A</label>
              </div>

              <div class="radio col-md-3 col-sm-6">
                <label><input type="radio" name="optradio" id="rdOptionB">Đáp án B</label>
              </div>

              <div class="radio  col-md-3 col-sm-6">
                <label><input type="radio" name="optradio"  id="rdOptionC">Đáp án C</label>
              </div>

              <div class="radio col-md-3  col-sm-6">
                <label><input type="radio" name="optradio" id="rdOptionD">Đáp án D</label>
              </div>

            </div>
        </div>

         


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnSubmit">Xác nhận</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $('#btnSubmit').click(function(){
    let question = $('#txaQuestion').val().trim();
    let option_a = $('#txaOptionA').val().trim();
    let option_b = $('#txaOptionB').val().trim();
    let option_c = $('#txaOptionC').val().trim();
    let option_d = $('#txaOptionD').val().trim();
    let answer = $('#rdOptionA').is(':checked')?'A':$('#rdOptionB').is(':checked')?'B':$('#rdOptionC').is(':checked')?'C':$('#rdOptionD').is(':checked')?'D':'';

    //ràng buộc dữ liệu
    if(question.length == 0 || option_a.length == 0 || option_b.length == 0 || option_c.length == 0 || option_d.length ==0){
      alert('Vui lòng nhập đầy đủ câu hỏi và các đáp án');
      return;
    }

    if(answer.length == 0){
      alert('Vui lòng chọn đáp án đúng');
      return;
    }

    let questionId = $('#txtQuestionId').val();

    if(questionId.length==0){// thêm mới câu hỏi
        $.ajax({
          url:'add_question.php',
          type:'post',
          data:{
            question:question,//bên trái là tên thuộc tính, bên phải là giá trị 
            option_a:option_a,
            option_b:option_b,
            option_c:option_c,
            option_d:option_d,
            answer:answer
          },
          success:function(data){
            alert(data);
            //reset lại giá trị cho các textarea
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

            $('#btnSearch').click();  
          }
      });
    }else{//cập nhật câu hỏi đã có
      $.ajax({
        url:'update.php',
        type:'post',
        data:{
          id:questionId,
          question:question,//bên trái là tên thuộc tính, bên phải là giá trị <-> tên biến ở phía trên
          option_a:option_a,
          option_b:option_b,
          option_c:option_c,
          option_d:option_d,
          answer:answer
        },
        success:function(data){
          alert(data); 
          $('#modalQuestion').modal('hide'); // ẩn modal sau khi update xong  
          $('#btnSearch').click();   
        }
      });
    }
    

  });
</script>