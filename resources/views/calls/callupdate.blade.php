<div class="modal-body">
    <form action="" method="POST">
        @csrf
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
                    <td>{{ $firstName }}</td>
                    <td>{{ $phone }}</td>
                    <td>{{ $email }}</td>
                </tr>
            </tbody>
        </table>
        <div class="form-group">
            <label for="howAreYou">Customer Status</label><br/>
            <input type="radio" class="form-control" id="status" name="status" value="reachable" onclick="showQuestion('reachable')"> Reachable <br/>
            <input type="radio" class="form-control" id="status" name="status" value="unreachable" onclick="showQuestion('unreachable')"> Unreachable
        </div>
        <div id="reachable"  style="display:none">
            <div class="form-group">
                <label for="howAreYou">How are you?</label>
                <input type="text" class="form-control" id="howAreYou" name="howAreYou">
            </div>
        </div>
        <div id="unreachable" style="display:none">
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
<script>
       $(document).on('click', '.call-btn', function () {
        $('#callDetailsModal').modal('show');
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