@extends('layouts.companyProfileLayout')

@section('body')
    <x-company-edit-profile-form
            :company="$company"
            :user="$user"/>
@endsection
