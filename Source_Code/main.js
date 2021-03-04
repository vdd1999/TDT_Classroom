
function get_size(val) {
	if (val > 1024 && val < Math.pow(1024,2)) {
		return (val/1024).toFixed(2) + " Kb";
	}
	else if  (val > Math.pow(1024,2)) {
		return (val/(1024*1024)).toFixed(2) + " Mb";
	}
	else  {
		return val + " byte";
	}
}
function countdown(){
  let duration = 5;
  let countDown = 5;
  let id = setInterval(() => {

      countDown --;
      if (countDown >= 0) {
          $('#counter').html(countDown);
      }
      if (countDown == -1) {
          clearInterval(id);
          window.location.href = 'login.php';
      }

  }, 1000);
}

function clone_list_file() {
	$('#file-list-tmp li:first-child').clone().prependTo('#save-file-list');
}

function fill_to_list_file(file,name) {
	let ul = document.querySelector('#save-file-list');
	let format = ul.querySelector('#show-file-format');
	let fname = ul.querySelector('#show-file-name');
	let size = ul.querySelector('#show-file-size');
  	fname.innerHTML = name;
  	size.innerHTML = get_size(file.size);
  	if (name.split('.')[1] == 'docx') {
      format.innerHTML = '<i class="fa fa-file-word-o" style="font-size:24px"></i>';
    }
    else if (name.split('.')[1] == 'pptx') {
      format.innerHTML = '<i class="fa fa-file-powerpoint-o" style="font-size:24px"></i>';
    }
    else if (name.split('.')[1] == 'xlxs') {
      format.innerHTML = '<i class="fa fa-file-excel-o" style="font-size:24px"></i>';
    }
    else if (name.split('.')[1] == 'zip') {
      format.innerHTML = '<i class="fa fa-file-zip-o" style="font-size:24px"></i>';
    }
    else if (name.split('.')[1] == 'pdf') {
      format.innerHTML = '<i class="fa fa-file-pdf-o" style="font-size:24px"></i>';
    }
}
function fill_to_list_file_assign(file,name) {
  let ul = document.querySelector('#save-file-list-assign');
  let format = ul.querySelector('#show-file-format-assign');
  let fname = ul.querySelector('#show-file-name-assign');
  let size = ul.querySelector('#show-file-size-assign');
    fname.innerHTML = name;
    size.innerHTML = get_size(file.size);
    if (name.split('.')[1] == 'docx') {
      format.innerHTML = '<i class="fa fa-file-word-o" style="font-size:24px"></i>';
    }
    else if (name.split('.')[1] == 'pptx') {
      format.innerHTML = '<i class="fa fa-file-powerpoint-o" style="font-size:24px"></i>';
    }
    else if (name.split('.')[1] == 'xlxs') {
      format.innerHTML = '<i class="fa fa-file-excel-o" style="font-size:24px"></i>';
    }
    else if (name.split('.')[1] == 'zip') {
      format.innerHTML = '<i class="fa fa-file-zip-o" style="font-size:24px"></i>';
    }
    else if (name.split('.')[1] == 'pdf') {
      format.innerHTML = '<i class="fa fa-file-pdf-o" style="font-size:24px"></i>';
    }
}
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

function postAssign(evt, tabName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontentPost");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinksPost");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}


//2
function clickPost(){
  document.getElementById('post-text').style.display = "block";
  document.getElementById('post-topic').style.display = "none";
}

function cancelPost(){
  document.getElementById('post-text').style.display = "none";
  document.getElementById('post-topic').style.display = "flex";
}

//3
function w3_open() {
  document.getElementById("main").style.marginLeft = "25%";
  document.getElementById("main2").style.marginLeft = "25%";
  document.getElementById("mySidebar").style.width = "25%";
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myBtn").style.display = 'none';
  document.getElementById("modal-backdrop1").style.display = 'block';
}
function w3_close() {
  document.getElementById("main").style.marginLeft = "0%";
  document.getElementById("main2").style.marginLeft = "0%";
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myBtn").style.display = 'block';
  document.getElementById("modal-backdrop1").style.display = 'none';
}

function w3_closePost() {
  document.getElementById("main").style.marginLeft = "0%";
  document.getElementById("main2").style.marginLeft = "auto";
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myBtn").style.display = 'block';
  document.getElementById("modal-backdrop1").style.display = 'none';
}

function w3_open_Admin() {
  document.getElementById("main").style.marginLeft = "17%";
  document.getElementById("mySidebar").style.width = "17%";
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("list").style.display = 'none';
  }
function w3_close_Admin() {
  document.getElementById("main").style.marginLeft = "0%";
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("list").style.display = 'inline-grid';
}

function showManage() {
  document.getElementById("manage1").style.display = "block";
  document.getElementById("manage2").style.display = "block";
}
//SINH VIÊN VÀO LỚP
function joinLop(matk) {
  let malop = $('#join-class').val();
  $.ajax({
      url:'LOP.php',
      method: "POST",
      dataType: "text",
      data: {
        action:'joinLophoc',
        matk:matk,
        malop:malop,
      },
      success: function(data) {
        console.log(data);
        if (data == '1'){
          $('#msg-join-class>p').html('Lớp không tồn tại hoặc đã bị xóa');
          $('#join-class').val('');
          $('#msg-join-class').removeAttr('hidden');
          setTimeout(function(){
            $('#msg-join-class').attr("hidden",true);
          },2000); 
        }
        else if (data == '2'){
          $('#msg-join-class>p').html('Tài khoản đã tồn tại trong lớp');
          $('#join-class').val('');
          $('#msg-join-class').removeAttr('hidden');
          setTimeout(function(){
            $('#msg-join-class').attr("hidden",true);
          },2000);           
        } 
        else {
          $('#msg-join-class>p').html('Vào lớp thành công, vui lòng đợi Giảng viên chấp nhận yêu cầu');
          $('#join-class').val('');
          $('#msg-join-class').removeAttr('hidden');
          setTimeout(function(){
            $('#msg-join-class').attr("hidden",true);
          },2000);
          $('#show-class').html(data);         
        }

      },
      error: function(data) {
        console.log(data);
      }
    });

}
//TẠO LỚP
function taolop(matk) {
  let tenlop = $('#tenlop').val();
  let monhoc = $('#monhoc').val();
  let phonghoc = $('#phonghoc').val();
  let anhdaidien = $('#tenfile').html()
  let error = "";
  if (tenlop == "") {
    error = "Vui lòng nhập tên lớp";
    show_error(error);
  }
  else if (monhoc == "") {
     error = "Vui lòng nhập môn học";
    show_error(error);
  }
  else if (phonghoc == "") {
     error = "Vui lòng nhập phòng học";
    show_error(error);
  }
  else if (anhdaidien == "Choose file") {
    error = "Vui lòng chọn ảnh đại diện";
    show_error(error);
  }else {
    $.ajax({
      url:'LOP.php',
      method: "POST",
      dataType: "text",
      data: {
        action:'createLophoc',
        matk:matk,
        tenlop:tenlop,
        monhoc:monhoc,
        phonghoc:phonghoc,
        anhdaidien:anhdaidien,
      },
      success: function(data) {
        console.log(data);
        $('#tenlop').val('');
        $('#monhoc').val('');
        $('#phonghoc').val('');
        $('#anhdaidien').val('')
        $('#show-class').html(data);
        $('#myModal2').modal('hide');
      },
      error: function(data) {
        console.log(data);
      }
    });
  }
}
//NỘP BÀI
function nopbai(mabd,matk,malop) {
  let bainop;
  $('.save-file-name').each(function() {
    bainop += $(this).html() +',';
  });
  bainop= bainop.replace('undefined','').split(',,')[0];
  $.ajax({
    url:'BAIDANG.php',
    method: "POST",
    dataType: "text",
    data: {
      action:'nopbai',
      mabd:mabd,
      matk:matk,
      malop:malop,
      bainop:bainop,
    },
    success: function(data) {
      console.log(data);
      $('#show-file-submit').html(data);
    },
    erro: function(data) {
      console.log(data);
    }
  })
}
//ĐĂNG BÀI
function dangbai(matk,malop) {
  let tepdinhkem;
  $('.save-file-name').each(function() {
    tepdinhkem += $(this).html() +',';
  });
  tepdinhkem= tepdinhkem.replace('undefined','').split(',,')[0];
  let noidung = $('#post-input').val();
  $.ajax({
    url:'BAIDANG.php',
    method: "POST",
    dataType: "text",
    data: {
      action:'createAnnouncement',
      matk:matk,
      malop:malop,
      loaibd:0,
      noidung:noidung,
      tieude:'',
      ngaynop:'',
      tepdinhkem:tepdinhkem,
    },
    success: function(data) {
      console.log(data);
      show_error('Đăng thông báo thành công');
      $('#post-input').val('');
      $('#show-post').html(data);

    },
    erro: function(data) {
      console.log(data);
    }
  })
}

function truncate() {
    $(".name_class").each(function() {
      var string = $(this).html();
      if (string.length > 30) {
          string = string.slice(0, 25) + "...";
          $(this).html(string);
      }
  });
}
//BUTTON CONFIRM SINH VIÊN
function acceptSV(id,malop) {
  let matk = id.split('tk')[1];
  $.ajax({
    url:'LOP.php',
    method: 'POST',
    dataType:'text',
    data: {action:'activeThanhvien',matk:matk,malop:malop},
    success: function(data) {
      console.log(data);
      $('#show-sv-active').html('');
      $('#show-sv-active').html(data);
    },
    error: function(data) {
      //console.log(data);
      console.log('Lỗi ');
    }
  })
}
function skipSV(id,malop) {
  let matk = $('#'+id).find('td:eq(3)').text();
  $.ajax({
    url:'LOP.php',
    method: 'POST',
    dataType:'text',
    data: {action:'skipThanhvien',matk:matk,malop:malop},
    success: function(data) {
      console.log(data);
      $('#show-sv-active').html('');
      $('#show-sv-active').html(data);
    },
    error: function(data) {
      //console.log(data);
      console.log('Lỗi');
    }
  })
}

function showAddClass() {
  document.getElementById("addClass").style.display = "block";

}
function deleteSV(id,malop,matk_gv) {
  let matk = id.split('tk')[1];
    $.ajax({
    url:'LOP.php',
    method: 'POST',
    dataType:'text',
    data: {action:'deleteMember',matk:matk,malop:malop,matk_gv:matk_gv},
    success: function(data) {
      console.log(data);
      $('#show-SV-client').html(data);
    },
    error: function(data) {
      console.log(data);
    }
  })

}
function deleteMember(matk,malop) {
    $.ajax({
    url:'../LOP.php',
    method: 'POST',
    dataType:'text',
    data: {action:'deleteMember_admin',matk:matk,malop:malop},
    success: function(data) {
      console.log(data);
      $("#show-ds-tv").html(data);
      //$("tbody>tr:nth-child(3)").after(data);
      //$('#show-SV-client').html(data);
    },
    error: function(data) {
      console.log(data);
    }
  })

}
function showDelete(id) {
  let items = $(".sv-item");
  for (i = 0; i < items.children(".item-content").length; i++) {
    let ID = items.children(".item-content")[i].querySelector("div[id^='tk']").id;
    if (id != ID) {
      document.getElementById(ID).style.display = "none";
    }
    else {
      if (document.getElementById(id).style.display == "block") {
        document.getElementById(id).style.display = "none";
      }
      else {
        document.getElementById(id).style.display = "block";
      }
    }
  }
}
function comment(matk,mabd,noidung) {
    $.ajax({
      url: 'BAIDANG.php',
      method: 'POST',
      dataType: 'text',
      data: {action:'comment',matk:matk,mabd:mabd,noidung:noidung},
      success: function(data) {
        $('#show-cmt').html('');
        $('#show-cmt').html(data);
        console.log(data);
      }
    })
}
function getComment(mabd,matk) {
      $.ajax({
      url: 'BAIDANG.php',
      method: 'POST',
      dataType: 'text',
      data: {action:'getComment',mabd:mabd,matk:matk},
      success: function(data) {
        $('#show-cmt').html('');
        $('#show-cmt').html(data);
        console.log(data);
      }
    })
}
function getfile(id) {
    var fileName = $('#'+id).val().split("\\").pop();
    $('#'+id).siblings("#file"+id).addClass("selected").html(fileName);
}
function show_error(msg) {
  $('#show-error').removeAttr('hidden');
  $('#msg-error').html(msg);
  setTimeout(function(){
    $('#show-error').attr("hidden",true);
  },2500);
}
function updateLop(malop) {
  let tenlop = $('#tenlop'+malop).val();
  let monhoc =$('#monhoc'+malop).val();
  let phonghoc = $('#phonghoc'+malop).val();
  let anhdaidien = $('#file'+malop).html();
  let error = "";
  if (tenlop == "") {
    error = "Vui lòng nhập họ tên";
    show_error(error);
  }
  else if (monhoc == "") {
     error = "Vui lòng nhập môn học";
    show_error(error);
  }
  else if (phonghoc == "") {
     error = "Vui lòng nhập phòng học";
    show_error(error);
  }
  else if (anhdaidien == "Choose file") {
    error = "Vui lòng chọn ảnh đại diện";
    show_error(error);
  }
  else {
    $.ajax({
    url:'../LOP.php',
    method: "POST",
    dataType: "text",
    data: {
      action:'updateClass',
      malop:malop,
      tenlop:tenlop,
      monhoc:monhoc,
      phonghoc:phonghoc,
      anhdaidien:anhdaidien,
    },
    success: function(data) {
      console.log(data);
      $(".collapse").collapse('hide');
      $('#show-ds-lop').html(data);
    },
    error: function(data) {
      console.log(data);
    }
  });  
  }

}
function editLop() {
  let tenlop = $('#tenlop').val();
  let monhoc =$('#monhoc').val();
  let malop = $('#malop').val();
  let phonghoc = $('#phonghoc').val();
  let error = "";
  if (tenlop == "") {
    error = "Vui lòng nhập họ tên";
    show_error(error);
  }
  else if (monhoc == "") {
     error = "Vui lòng nhập môn học";
    show_error(error);
  }
  else if (phonghoc == "") {
     error = "Vui lòng nhập phòng học";
    show_error(error);
  }
  else {
    $.ajax({
    url:'LOP.php',
    method: "POST",
    dataType: "json",
    data: {
      action:'editClass',
      malop:malop,
      tenlop:tenlop,
      monhoc:monhoc,
      phonghoc:phonghoc
    },
    success: function(data) {
      console.log(data);
      location.reload();
    },
    error: function(data) {
      console.log(data);
    }
  });  
  }

}
function deleteComment(mabd,mabl,matk) {
  $.ajax({
    url:'BAIDANG.php',
    method: "POST",
    dataType: "text",
    data: {
      action:'deleteComment',
      mabd:mabd,
      mabl:mabl,
      matk:matk
    },
    success: function(data) {
      console.log(data);
      $('#show-cmt').html(data);
    },
    error: function(data) {
      console.log(data);

    }
  });
}
function deleteBaidang(mabd,malop,matk) {
  $.ajax({
    url:'LOP.php',
    method: "POST",
    dataType: "text",
    data: {
      action:'deleteBaidang',
      mabd:mabd,
      malop:malop,
      matk:matk
    },
    success: function(data) {
      console.log(data);
      $('#show-post').html(data)
      show_error('Xóa thông báo thành công');
      return false;
    },
    error: function(data) {
      console.log(data);
    }
  });
}
function deleteBaidang_admin(mabd,malop) {
  $.ajax({
    url:'../BAIDANG.php',
    method: "POST",
    dataType: "text",
    data: {
      action:'deleteBaidang_admin',
      mabd:mabd,
      malop:malop,
    },
    success: function(data) {
      console.log(data);
      $('#show-post-admin').html(data)
      show_error('Xóa thông báo thành công');
    },
    error: function(data) {
      console.log(data);
    }
  });
}
function deleteClass(malop) {
  $.ajax({
    url:'../LOP.php',
    method: "POST",
    dataType: "text",
    data: {
      action:'deleteClass',
      malop:malop
    },
    success: function(data) {
      console.log(data);
      $(".collapse").collapse('hide');
      $('#show-ds-lop').html(data);
    },
    error: function(data) {
      console.log(data);
    }
  });
}
//TO-DO
function showNodue() {
  let item = $(".nodue-details");
    if (item.css("display")=="flex") {
      item.css("display","none");
    }
    else {
      item.css("display","flex");
    }
   
}
function phanquyen(matk,trangthai) {
$.ajax({
    url:'../LOP.php',
    method: "POST",
    dataType: "text",
    data: {
      action:'phanquyen',
      matk:matk,
      trangthai:trangthai
    },
    success: function(data) {
      console.log(data);
      $('#show-ds-tk').html(data);
    },
    error: function(data) {
      console.log(data);
    }
  });
}
function invitebyEmail(malop,email) {
  $.ajax({
    url:'LOP.php',
    method: "POST",
    dataType: "text",
    data: {
      action:'addClassbyEmail',
      malop:malop,
      email:email
    },
    success: function(data) {
      console.log(data);
      show_error(data);
    },
    error: function(data) {
      console.log(data);
    }
  });
}
$(document).ready(function() {
  $(function() {
    var mabd = "";
    var matk = "";
    $('#myModal3').on('show.bs.modal', function(e) {
      mabd = $(e.relatedTarget).data("mabd");
      matk = $(e.relatedTarget).data("matk");
      getComment(mabd,matk);
    });

    $('#send').click(function() {
      let noidung = $('#addCMT').val();
      comment(matk,mabd,noidung);
      $('#addCMT').val('');
    });
  });

  //MyMODAL MỜI VÀO LỚP
$(function() {
  let malop = "";
  $('#modalAddStudent').on('show.bs.modal', function(e) {
    malop = $(e.relatedTarget).data("malop");
  });
  $('#invite-btn').click(function() {
    let email = $('#invite-class').val();
    invitebyEmail(malop,email);
    ('#invite-class').val('');
  });
  $('#invite-class').on('keypress', function(e){
    if(e.keyCode == '13'){
      let email = $('#invite-class').val();
      invitebyEmail(malop,email);
      ('#invite-class').val('');
      $('#modalAddStudent').modal('hide');

    }
  })
});
  $('#cmt-assign').on('keypress', function(e){
    if(e.keyCode == '13'){
      let noidung = $('#cmt-assign').val();
      let mabd = $('#cmt-assign').data("mabd");
      let matk = $('#cmt-assign').data("matk");
      comment(matk,mabd,noidung);
      $('#cmt-assign').val('');
    }
});
//-------------------------------DETAIL POST
$("#file").on("change", function() {
  $('#save-file-list').removeAttr('hidden');
  let file = document.getElementById("file").files[0];
  let fileName = $(this).val().split("\\").pop();
  fill_to_list_file(file,fileName);
});
$("#file-assign").on("change", function() {
  $('#save-file-list-assign').removeAttr('hidden');
  let file = document.getElementById("file-assign").files[0];
  let fileName = $(this).val().split("\\").pop();
  fill_to_list_file_assign(file,fileName);
});

$(".post-input").bind('input propertychange', function(){
  $('.btn-post').addClass('changetext');

  if(this.value.length == 0){
      $('.btn-post').removeClass('changetext');
  }
});
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".show-file").addClass("selected").html(fileName);
});
 //---------------------------------------UPLOAD FILE QUẢN LT1 LỚP
})
$(document).ready(function(){
  $("#search-lop").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".dslop").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

//mới nè
function showinfoClass() {
  let item = $(".info-Class");
  let down = $(".down");
  let up = $(".up");
  item.css("display","block");
  down.css("display","none");
  up.css("display","block");   
  $(".title").css("border-bottom-left-radius","0");
  $(".background").css("border-bottom-right-radius","0");
}

function offinfoClass() {
  let item = $(".info-Class");
  let down = $(".down");
  let up = $(".up");
  item.css("display","none");
  down.css("display","block");
  up.css("display","none");  
  $(".title").css("border-bottom-left-radius","15px");
  $(".background").css("border-bottom-right-radius","15px"); 
}
