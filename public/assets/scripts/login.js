$(document).ready(function(){$("#loginBtn").click(function(){var e=$("#email").val(),a=$("#password").val(),t=$("#url").val();""==e.length?Swal.fire({type:"warning",title:"Oops...",text:"Email Wajib Diisi !"}):""==a.length?Swal.fire({type:"warning",title:"Oops...",text:"Password Wajib Diisi !"}):$.ajax({url:"cek_login",type:"POST",dataType:"json",data:{email:e,password:a},success:function(e){e.status?Swal.fire({type:"success",title:e.message,text:"Anda akan di arahkan dalam 3 Detik",timer:3e3,showCancelButton:!1,showConfirmButton:!1}).then(function(){if("administrator"==e.result.role)return window.location.href=t+"dashboard/admin_dash";window.location.href=t+"dashboard"}):Swal.fire({type:"error",title:e.message,text:"silahkan coba lagi!"})},error:function(e){Swal.fire({type:"error",title:"Opps!",text:"server error!"}),console.log(e)}})})});