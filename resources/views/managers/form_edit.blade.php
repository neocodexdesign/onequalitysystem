<div class="box-body">

    <input class="form-control"
        name="id_managers"
        id="id_managers"
        readonly="readonly"
        type="hidden">

    <div class="form-group">
        <label>Name</label>
        <input type="text"
            class="form-control"
            name="name_managers"
            id="name_managers"
            placeholder="Enter managers name">
    </div>

    <div class="form-group">
        <label for="email_managers">Email address</label>
        <i class="fa fa-envelope"></i>
        <br />
        <input type="email"
            name="email_managers"
            id="email_managers"
            class="form-control"
            placeholder="Enter managers e-mail">
    </div>

    <div class="form-group">
        <label>Mobile Phone</label>
        <i class="fa fa-phone"></i>
        <br />
        <input type="text"
            name="phone_managers"
            id="phone_managers"
            class="form-control"
            data-inputmask="&quot;mask&quot;: &quot;(999) 999-9999&quot;"
            data-mask=""
            placeholder="Enter managers phone number">
    </div>
    <br />
    <div class="form-group">
        {!! Form::label('Name', 'Name of user:', array('class' => 'control-label' )) !!}

            <select name="id_users" id="id_users">
                @foreach($users as $user)
                    <option
                        value="{{ $user->id }}"> {{trim( $user->name ) }}
                    </option>
                @endforeach
            </select>



    </div>

</div>
<!--
/{/!! Form::select('id_users', $users->pluck('name'), $users->pluck('id'), [], ['class' => 'form-control']) !!}
-->
