<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Todos</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">


    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
   

</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-6  ms-auto me-auto">
                <h1 align="center">Laravel Todos APP</h1>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-sm-6 ms-auto me-auto ">

                <div class="section-title">
                    Add Todo
                </div>
                <div class="alert alert-success">
                    Todo has been successfully added
                </div>
            <div class="add-todo">
                <input type="text" id="new-todo" required placeholder="type here . . . " class="p-2 input" style="width: 70%">
                <button onclick="addTodo()" class="submitbtn" id="submitbtn" style="width: 20%">Add Todo</button>
            </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-sm-6  ms-auto me-auto">
                <div class="section-title">
                    All Todos
                </div>
                <div class="alltodos" id="allTodosContainer">
                    @if($data && count($data) > 0)
                        @foreach ($data as $todo)
                            <div class="singletodo">
                                <div class="title">
                                    {{ $todo->todo }}
                                </div>
                                <div class="deletetodo" onclick="deleteTodo({{ $todo->id }}, this.parentNode)">
                                    <span>&times;</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="notodos" id="notodos">No Todos</div>
                    @endif
                </div>                
            </div>
        </div>
    </div>


    <script>
        // Function to add a new todo using fetch
        function addTodo() {
            var newTodo = document.getElementById('new-todo').value;
            var submitbtn = document.getElementById('submitbtn');
            var newTodoInput = document.getElementById('new-todo');
            var notodos = document.getElementById('notodos');
            if(newTodo != ""){
                submitbtn.innerHTML="Adding ...";
                submitbtn.disabled = true;
                submitbtn.style.backgroundColor = "grey";
            }


            fetch('{{ route("todos.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    newTodo: newTodo
                })
            })
            .then(response => response.json())
            .then(data => {

                // Append the new todo to the todos container
                var allTodosContainer = document.getElementById('allTodosContainer');
                var singleTodo = document.createElement('div');
                singleTodo.className = 'singletodo';
                singleTodo.innerHTML = `
                    <div class="title">${data.newTodo}</div>
                    <div class="deletetodo" onclick="deleteTodo(${data.todoId}, this.parentNode)">
                        <span>&times;</span>
                    </div>

                `;
                allTodosContainer.prepend(singleTodo);
                submitbtn.innerHTML="Add Todo";
                submitbtn.disabled = false;
                submitbtn.style.backgroundColor = "black";
                newTodoInput.value = "";
                notodos.style.display = 'none';


                // Show the success message
                var alertSuccess = document.querySelector('.alert-success');
                // if (alertSuccess) {
                //     alertSuccess.style.display = 'block';
                // }


                // setTimeout(function() {
                //     alertSuccess.style.display = 'none';
                // }, 3000);

                console.log("Data added");
            })
            .catch(error => {
                console.log("Data not added");
                // console.error(error);
            });
        }


        // Function to delete a todo using fetch
        function deleteTodo(id, todoElement) {
            todoElement.style.display = "none";

            fetch('{{ url("todos/delete") }}/' + id, {
                method: 'GET' // Specify the HTTP method as GET
            })
            .then(response => {
                // Check if the response status is in the success range (200-299)
                if (!response.ok) {
                    throw new Error('Failed to delete todo'); // Throw an error if response is not successful
                }
                return response.json(); // Parse the response body as JSON
            })
            .then(data => {
                // Hide the todo item's DOM element after successful deletion
                if (todoElement) {
                    console.log(data.deletesuccess); // Log success message to console
                } else {
                    console.error('todoElement is undefined');
                }

            })
            .catch(error => {
                console.error(error); // Log any errors to console
                // Handle error gracefully, e.g., display an error message to the user
            });

            setTimeout(() => {
                // Check if any element with class singletodo exists
                const singletodoExists = document.querySelector('.singletodo') !== null;

                // Show or hide the "No Todos" message based on singletodoExists
                const notodos = document.getElementById('notodos');
                if (!singletodoExists) {
                    notodos.style.display = 'block'; // Show "No Todos" message
                }else{
                    // notodos.style.display = 'block';
                }
            }, 3000);

        }



    </script>
</body>
</html>
