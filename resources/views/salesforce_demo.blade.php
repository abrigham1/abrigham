@extends('layouts.master')

@section('title', 'ABrigham - Salesforce demo')

@section('content')
    <h1>Salesforce Demo</h1>
    <form>
        @if($contacts && is_array($contacts))
            <div class="form-group">
                <label for="salesforceContacts">Contacts</label>
                <select name="contact" id="salesforceContacts" class="form-control">
                    @foreach ($contacts as $contact)
                        @if(array_key_exists('Id', $contact) && array_key_exists('Name', $contact))
                            <option value="{{ $contact['Id'] }}">{{ $contact['Name'] }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        @else
            No Contacts Available
        @endif
    </form>
@endsection