<div class="container">
   <div class="row">
      <div class="col-sm">
         <label>User Id</label> : <strong>{{ $user->id }}</strong>
      </div>
   </div>

   <div class="row">
     <div class="col-sm">
         <label>First Name</label> : <strong>{{ $user->first_name }}</strong>
      </div>
   </div>

   <div class="row">
     <div class="col-sm">
         <label>Last Name</label> : <strong>{{ $user->last_name }}</strong>
      </div>
   </div>

   <div class="row">
     <div class="col-sm">
         <label>Email</label> : <strong>{{ $user->email }}</strong>
      </div>
   </div>

   <div class="row">
     <div class="col-sm">
         <label>Age</label> : <strong>{{ $user->getAge() }}</strong>
      </div>
   </div>

   <div class="row">
     <div class="col-sm">
         <label>Residential Address</label> : <strong>{{ $user->address }}</strong>
      </div>
   </div>

   <div class="row">
     <div class="col-sm">
         <label>Department</label> : <strong>{{ $user->department->name }}</strong>
      </div>
   </div>

   <div class="row">
     <div class="col-sm">
         <label>Roles</label> : <strong>{{ $user->getRoles() }}</strong>
      </div>
   </div>
</div>