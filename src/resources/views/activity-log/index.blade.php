@extends('ActivityLog::layouts.main')
@section('content')
  <x-ActivityLog::content-wrapper>
    <div>
      @include('ActivityLog::layouts.status')
      <div class="table-responsive">
        <table class="table hover striped">
          <thead>
            <tr>
              <th>アクセス日時</th>
              <th>パス</th>
              <th>アクティビティ</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($logs as $log)
              <tr>
                <td>{{ $log->created_at }}</td>
                <td>{{ $log->path }}</td>
                <td>{{ $log->activity }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="mt-2">
        {{ $logs->links() }}
      </div>
    </div>
  </x-ActivityLog::content-wrapper>
@endsection
