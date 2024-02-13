@foreach ($permissions as $area => $permissionsArray)
    @if (count($permissionsArray) == 1)
        <?php $localPermission = $permissionsArray[0]; ?>

    @endif
@endforeach
