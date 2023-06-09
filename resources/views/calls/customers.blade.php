<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calls</title>
</head>
<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Calls') }}
            </h2>
        </x-slot>
        <div class="container bg-gray-400 rounded">
            @if (session()->has('success'))
                <div class="alert alert-success" id="alert">
                    {{session()->get('success')}}
                <button style="float:right" type="button" class="close" data-dismiss="alert" >x</button>
                </div>
            @elseif (session()->has('error'))
                <div class="alert alert-danger" id="alert">
                    {{session()->get('error')}}
                <button style="float:right" type="button" class="close" data-dismiss="alert" >x</button>
                </div>
            @endif
            @if (session()->has('successful-import'))
            <div class="alert alert-success" id="alert">
                {{session()->get('successful-import')}}
            <button style="float:right" type="button" class="close" data-dismiss="alert" >x</button>
            </div>
            @endif
            <div class="row mt-3">
                <div class="d-flex justify-content-center col-md-12">
                    <form style="width:400px" action="{{route('customersupload')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="center md-3 pt-4">
                            <label class="form-label">Choose your file</label>
                                <input type="file" class="form-control" name="myfile">
                                @error('myfile')
                                <span style="color: rgb(175, 16, 16)">{{$message}}</span>
                                @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 mb-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="container mt-4 bg-gray-400 rounded"  id="calls">
            <div class="row p-2 d-flex">
                <div class="col-md-4">
                    <h1>USERS</h1>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <a href="{{route('customerdownload')}}" class="btn btn-primary">Download</a>
                </div>
            </div>
            <form action="{{route('callsearch')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="col-md-3">
                        <label for="">Phone</label>
                        <input type="text" class="form-control" name="phone">
                    </div>
                    <div class="col-md-3">
                        <label for="">From Date</label>
                        <input type="date" class="form-control" name="froDate">
                    </div>
                    <div class="col-md-3">
                        <label for="">To Date</label>
                        <input type="date" class="form-control" name="toDate">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success">Search</button>
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
                        <tbody id="tableBody">
                            @if(!empty($data))
                                @php
                                    $i=1;
                                @endphp
                                @foreach ($data as $call)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$call->first_name}} {{$call->last_name}}</td>
                                        <td>{{$call->phone}}</td>
                                        <td>{{$call->created_at}}</td>
                                        <td> <button class="btn btn-success call-btn" data-toggle="modal" data-target="#callDetailsModal"
                                            data-firstname="{{ $call->first_name }}" data-phone="{{ $call->phone }}" data-email="{{ $call->email }}">
                                        Call
                                    </button>
                                    
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                            <tr id="responseRow" style="">
                                <td colspan="5" class="text-center" style="color:brown">No data is available for the search</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="justify-content-center">
                {{ $data->links() }}
            </div>
        </div>
        
        <div class="modal fade" id="callDetailsModal" tabindex="-1" role="dialog" aria-labelledby="callDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="callDetailsModalLabel">Call Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeCallDetailsModal">
                            <span aria-hidden="true">&times;</span>
                        </button>                        
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td id="modalFirstName"></td>
                                    <td id="modalPhone"></td>
                                    <td id="modalEmail"></td>
                                </tr>
                            </tbody>
                        </table>
                        <form action="{{route('callupdate')}}" method="POST">
                            @csrf
                            <input type="hidden" id="hiddenPhone" name="hiddenPhone">
                            <div class="form-group">
                                <label for="status">Customer Status</label><br/>
                                <input type="radio" class="form-control" id="status" name="status" value=1 onclick="showQuestion('reachable')"> Reachable <br/>
                                <input type="radio" class="form-control" id="status" name="status" value=2 onclick="showQuestion('unreachable')"> Unreachable
                            </div>
                            <div id="reachable" style="display: none;">
                                <div class="form-group">
                                    <label for="howAreYou">How are you?</label>
                                    <input type="text" class="form-control" id="howAreYou" name="howAreYou">
                                </div>
                            </div>
                            <div id="unreachable" style="display: none;">
                                <div class="form-group">
                                    <label for="reason">Reason for being unreachable</label>
                                    <div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="reason" id="reasonNetwork" value="network">
                                            <label class="form-check-label" for="reasonNetwork">
                                                Poor Network Connection
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="reason" id="reasonBusy" value="busy">
                                            <label class="form-check-label" for="reasonBusy">
                                                Took too long to respond
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="reason" id="reasonHanged" value="hanged">
                                            <label class="form-check-label" for="reasonHanged">
                                                Hanged up
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary float-right color:black">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>        
<script>
    $(document).on('click', '.call-btn', function () {
        // Get the call details from the clicked button's data attributes
        const firstName = $(this).data('firstname');
        const phone = $(this).data('phone');
        const email = $(this).data('email');

        // Set the call details in the modal
        $('#modalFirstName').text(firstName);
        $('#modalPhone').text(phone);
        $('#modalEmail').text(email);

         // Set the hidden phone value
        $('#hiddenPhone').val(phone);

        // Show the modal
        $('#callDetailsModal').modal('show');
    });
    
    //close the card
    $(document).on('click', '#closeCallDetailsModal', function () {
        $('#callDetailsModal').modal('hide');
    });


    function showQuestion(status) {
        var questionReachable = document.getElementById('reachable');
        var questionUnreachable = document.getElementById('unreachable');

        if (status === 'reachable') {
            questionReachable.style.display = 'block';
            questionUnreachable.style.display = 'none';
        } else if (status === 'unreachable') {
            questionReachable.style.display = 'none';
            questionUnreachable.style.display = 'block';
        }
    }
</script>

</body>
