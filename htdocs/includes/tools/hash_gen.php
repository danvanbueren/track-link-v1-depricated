<!doctype html>
<html lang="en">
    <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title>Hash Generator</title>
    </head>

<body>

<style>
html,
body {
    height: 100%;
}

.container {
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;

}

.card {
	min-width: 640px;
	height: 280px;
</style>

	<div class="container">
		<div class="card">
			<div class="card-header">
				<h1>Hash Generator</h1>
			</div>
			<div class="card-body">
				<div class="input-group mb-3">
  					<div class="input-group-prepend">
    					<span class="input-group-text" id="basic-addon1">Input</span>
  					</div>
  					<input type="text" id="input" class="form-control" placeholder="Text" autocomplete="off" onkeyup="update()">
				</div>
				<div class="input-group mb-3">
  					<div class="input-group-prepend">
    					<span class="input-group-text" id="basic-addon1">Hash</span>
  					</div>
  					<p id='response' class="form-control"><span class="text-muted"><i>waiting for input...</i></span></p>
				</div>
			</div>
			<div class="card-footer text-muted">
				built by <a href="https://github.com/danvanbueren">@danvanbueren</a>
			</div>
		</div>
	</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js "></script>
<script>
    function update() {
        $(document).ready(function(){
            $('#response').html("");
            $.ajax({
                type: 'POST',
                url: '/includes/tools/post_receiver.php',
                data: "data="+$('#input').val()
            })
            .done(function(data){
                $('#response').html(data);
            })
            .fail(function() {
                $('#response').html("");
            });
            return false;
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
 
</body>
</html>