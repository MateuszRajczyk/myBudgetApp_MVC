function showPassword()
{
  var x = document.getElementById("myInput");
  if (x.type === "password") {
    x.type = "text";
	document.getElementById("toggler").innerHTML = '<i class="icon-eye-off-1" id="toggler"></i>'
  } else {
    x.type = "password";
	document.getElementById("toggler").innerHTML = '<i class="icon-eye-1" id="toggler"></i>'
  }

}