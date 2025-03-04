<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>Document</title>
</head>
<body>
    <!-- Special version of Bootstrap that only affects content wrapped in .bootstrap-iso -->
<link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" /> 

<!-- Inline CSS based on choices in "Settings" tab -->
<style>.bootstrap-iso .formden_header h2, .bootstrap-iso .formden_header p, .bootstrap-iso form{font-family: Arial, Helvetica, sans-serif; color: black}.bootstrap-iso form button, .bootstrap-iso form button:hover{color: white !important;} .asteriskField{color: red;}</style>

<!-- HTML Form (wrapped in a .bootstrap-iso div) -->
<div class="bootstrap-iso">
 <div class="container-fluid">
  <div class="row">
   <div class="col-md-6 col-sm-6 col-xs-12">
    <form action="output.php" method="post">
     <div class="form-group ">
      <label class="control-label " for="nama">
       Nama Lengkap
      </label>
      <input class="form-control" id="nama" name="nama" type="text"/>
     </div>
     <div class="form-group ">
      <label class="control-label " for="select">
       Mata Kuliah
      </label>
      <select class="select form-control" id="select" name="select">
       <option value="First Choice">
        Pemograman Web
       </option>
       <option value="Second Choice">
        UI/UX
       </option>
       <option value="Third Choice">
        Statistik Probabilitas
       </option>
      </select>
     </div>
     <div class="form-group ">
      <label class="control-label " for="nama1">
       Nilai UTS
      </label>
      <input class="form-control" id="nama1" name="nama1" type="text"/>
     </div>
     <div class="form-group ">
      <label class="control-label " for="nama2">
       Nilai UAS
      </label>
      <input class="form-control" id="nama2" name="nama2" type="text"/>
     </div>
     <div class="form-group ">
      <label class="control-label " for="nama3">
       Nilai Tugas Praktikum
      </label>
      <input class="form-control" id="nama3" name="nama3" type="text"/>
     </div>
     <div class="form-group">
      <div>
       <button class="btn btn-primary " name="submit" type="submit">
        Submit
       </button>
      </div>
     </div>
    </form>
   </div>
  </div>
 </div>
</div>

</body>
</html>