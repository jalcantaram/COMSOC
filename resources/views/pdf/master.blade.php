<!DOCTYPE html>
<html lang="en">
<head>
@yield('head')	
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<style type="text/css">    
@page {
	size: letter;
	margin-top: 60px;
	margin-left: 60px;
	margin-right: 60px;
 	margin-bottom: 180px;
}
body{	
 font-family: Arial, Helvetica, sans-serif;
}
.color{
background-color: #666666;
color: #ffffff; 

}
.pagenum:after {
content: counter(page);

}

.footer {
bottom: -50px;
width: 100%;
text-align: center;
position: fixed;
}

th, td {
    border: 1px solid black;
}

</style>

	<div style="width:100%;">
		<div style="text-align:right; float: right; vertical-align: text-top">
			<img src="{{ asset('assets/logotipos/cdmx.png') }}" style="width:250px;">
		</div>
		<p><br /></p>
	</div>



@yield('container')
	
    	
	   <div class="footer">  		
			<img src="{{ asset('assets/logotipos/om.png') }}" style="width:50px; font-size: 6px;" align="right" >
			<div style="font-size:8px; text-align:center">
				Página <span class="pagenum"></span> 
			</div>


	    </div> 
	
    
	
</html>