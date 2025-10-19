@extends('dashboard.admin.layouts.app')

@section('title', 'Visit Detail')

@section('content')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Visit Detail</h4>
                <a href="{{ route('dashboard.visits.index') }}" class="btn btn-sm btn-secondary">Back</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Date</dt>
                    <dd class="col-sm-9">{{ $visit->date }}</dd>

                    <dt class="col-sm-3">IP</dt>
                    <dd class="col-sm-9">{{ $visit->ip }}</dd>

                    <dt class="col-sm-3">URL</dt>
                    <dd class="col-sm-9">{{ $visit->url }}</dd>

                    <dt class="col-sm-3">Accept-Language</dt>
                    <dd class="col-sm-9">{{ $visit->accept_language ?? '-' }}</dd>

                    <dt class="col-sm-3">User Agent</dt>
                    <dd class="col-sm-9">
                        <pre style="white-space:pre-wrap">{{ $visit->user_agent }}</pre>
                    </dd>

                    <dt class="col-sm-3">Headers (JSON)</dt>
                    <dd class="col-sm-9">
                        <pre style="white-space:pre-wrap">{{ $visit->headers_json ?? '{}' }}</pre>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
