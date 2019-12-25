<div class="list-group-item">
  <img class="mr-3" src="{{ $user->gravatar() }}" alt="{{ $user->name }}" width=32>
  <a href="{{ route('users.show', $user) }}">
    {{ $user->name }}
  </a>
  @can('destroy', $user)
    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="float-right">
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModal">
        删除
      </button>

      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
              您确定要删除吗？
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger delete-btn">删除</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  @endcan
</div>
