{!! Form::open(['route' => 'login']) !!}

<div class="form-group">
    {!! Form::label('Username', 'Your Name') !!}
    {!! Form::text('Username', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('Email', 'E-mail Address') !!}
    {!! Form::text('Email', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::textarea('msg', null, ['class' => 'form-control']) !!}
</div>

{!! Form::submit('Submit', ['class' => 'btn btn-info']) !!}

{!! Form::close() !!}

<!-- <!doctype html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    </head>
	<body>
		<form name="submitForm" method="POST" action="{{ url('/home') }}">

		    <div class="container">
		    	<h3 class="col-lg-offset-2 form-group">Login To Continue</h3>
				<div class="form-group col-lg-12">
					<label for="userName" class="control-label text-right col-lg-2">User Name</label>
					<div class="col-lg-3">
						<input id="userName" name="userName" type="text" class="form-control" />
					</div>
				 </div>
				 <div class="form-group col-lg-12">
					<label for="password" class="control-label text-right col-sm-2">Password</label>
					<div class="col-sm-3">
						<input type="password" name="password" class="form-control" />
					</div>
				 </div>
				 <div class="form-group">
					 <div class="col-lg-offset-4 col-lg-3">
						<input type="submit" value="Submit" class="btn btn-primary" />
					 </div>
				</div>
				 <div class="form-group col-lg-12">
					<div class="col-lg-offset-2" style="color: red"></div>
				 </div>
			</div>
		</form>
	</body>
</html> -->