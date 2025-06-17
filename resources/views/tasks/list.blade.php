

   <li>
       <div class="info-task">
           <div class="check {{$check ?? ''}}">
               <span class="checkbox" data-action="{{route('tasks.update', ['task' => $task])}}" data-id="{{$task->id}}" data-status="{{$task->completed ? '1' : '0'}}"></span>
               <span class="task-text" contenteditable="false">{{$task->name}}</span>
           </div>
           <div class="task-option">
               
               <button class="btn edit"><i class='bx bxs-edit-alt'></i></button>
               <button class="btn save" data-action="{{route('tasks.update', ['task' => $task])}}" data-id="{{$task->id}}"><i class='bx bx-save'></i></button>
               <button class="btn delete" data-action="{{route('tasks.destroy', ['task' => $task])}}" data-id="{{$task->id}}"><i class='bx bxs-trash'></i></button>
           </div>
       </div>
       <div class="task-details">
           <i class='bx bx-menu'></i>
           <span>{{$task->description}}</span>
       </div>
   </li>





