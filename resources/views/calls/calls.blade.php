<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calls</title>
</head>
<body>
    <x-app-layout>
        <div class="container bg-gray-400 rounded">
           
            <div class="row mt-3">
                <div class="d-flex justify-content-center col-md-12">
                    @if (session()->has('sucess'))
                        <div class="alert alert-success" id="alert">
                            {{session()->get('success')}}
                        <button style="float:right" type="button" class="close" data-dismiss="alert" >x</button>
                        </div>
                    @endif
                    <form style="width:400px" action="{{url('Calls/upload')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="center md-3 pt-4">
                            <label class="form-label">Choose your file</label>
                                <input type="file" class="form-control" name="select_file">
                                @error('select_file')
                                <span style="color: rgb(175, 16, 16)">{{$message}}</span>
                                @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 mb-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="container mt-4 bg-gray-400 rounded"  id="calls">
            <div class="row p-2">
                <div class="center">
                    <h1>USERS</h1>
                </div>
            </div>
            
            <form action="{{url('calls/search')}}" method="POST" enctype="multipart/form-data">
                @csrf
                 <div class="row d-flex justify-content-center">
                    <div class="col-md-3 p-1">
                        <input type="text" class="form-control rounded-pill" value="{{old('name')}}" name="name" placeholder="Enter Name">
                        @error('name')
                        <span style="color: rgb(175, 16, 16)">{{$message}}</span> 
                        @enderror
                    </div>
                    <div class="col-md-3 p-1">
                        <input type="text" class="form-control rounded-pill" value="{{old('phone')}}" name="phone"  placeholder="Enter Phone">
                        @error('phone')
                        <span style="color: rgb(175, 16, 16)">{{$message}}</span> 
                        @enderror
                    </div>
                    <div class="col-md-3 p-1">
                        <input type="date" class="form-control rounded-pill" value="{{old('date')}}" name="date">
                        @error('date')
                        <span style="color: rgb(175, 16, 16)">{{$message}}</span> 
                        @enderror
                        <button type="submit" class="btn btn-primary mt-2 float-right">Search</button>

                    </div>
                    
                </div>
            </form>
            
            <div class="row" id="allcalls">
                <div class="d-flex p-3 justify-content-center align-items-center">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($data))
                                @php
                                    $i=1;
                                @endphp
                                @foreach ($data as $call )
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$call->name}}</td>
                                    <td>{{$call->phone}}</td>
                                    <td>{{$call->created_at}}</td>
                                    <td> <button href="" class="btn btn-success" onclick="container()">Call</button> </td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="5">No data Available</td>
                            </tr>                            
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="container mt-4 bg-gray-400 rounded" id="question" style="display: none">
            <div class="row">
                <h4>Call Information</h4>
                <form action="">
                    <div class="form-control">
                        <label>
                          <input type="radio" name="status" value="reachable" id="reachable" onclick="showQuestion('reachable')"> Reachable
                        </label>
                        <br>
                        <label>
                          <input type="radio" name="status" value="unreachable" id="unreachable" onclick="showQuestion('unreachable')"> Unreachable
                        </label>
                      </div>
                      
                      <div id="questionContainer">
                        <div id="questionReachable" style="display: none">
                          <label>How are you?</label>
                          <input type="text" name="howAreYou">
                        </div>
                        <div id="questionUnreachable" style="display: none">
                          <label>Why not reachable?</label><br/>
                          <label>
                            <input type="radio" name="reason" value="network"> Poor Network Connection
                          </label>
                          <br>
                          <label>
                            <input type="radio" name="reason" value="busy"> Took too long to respond
                          </label><br/>
                          <label>
                            <input type="radio" name="reason" value="hanged"> Hanged up
                          </label>
                        </div>
                      </div>                      
                </form>
            </div>
        </div>

    </x-app-layout>
     
    <script>
        function showQuestion(option) {
          var questionReachable = document.getElementById('questionReachable');
          var questionUnreachable = document.getElementById('questionUnreachable');
        
          if (option === 'reachable') {
            questionReachable.style.display = 'block';
            questionUnreachable.style.display = 'none';
          } else if (option === 'unreachable') {
            questionReachable.style.display = 'none';
            questionUnreachable.style.display = 'block';
          }
        }
        function container(){
            var allcalls=document.getElementById('allcalls');
            allcalls.style.display='none';
            document.getElementById('question').style.display = 'block';
        }
        </script>
</body>
