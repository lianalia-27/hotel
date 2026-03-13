@extends('layouts.app')
@section('title', 'Kelola Karyawan')
@section('page-title', 'Kelola Karyawan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Karyawan</li>
@endsection

@section('content')
<div class="row g-4">
    <!-- User List -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><i class="bi bi-people-fill me-2 text-success"></i>Daftar Karyawan</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:34px;height:34px;border-radius:50%;background:var(--ppkd-primary-lt);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.85rem;color:var(--ppkd-accent);">
                                    {{ strtoupper(substr($user->name,0,1)) }}
                                </div>
                                <span style="font-weight:600;">{{ $user->name }}</span>
                                @if($user->id === auth()->id()) <span style="font-size:.7rem;background:#d1fae5;color:#065f46;padding:2px 6px;border-radius:10px;">Saya</span> @endif
                            </div>
                        </td>
                        <td style="font-size:.85rem;color:#6b8f78;">{{ $user->email }}</td>
                        <td>
                            <span class="badge-status {{ $user->role === 'administrator' ? 'badge-checked_in' : 'badge-reserved' }}">
                                {{ $user->role === 'administrator' ? 'Administrator' : 'Resepsionis' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-status {{ $user->is_active ? 'badge-available' : 'badge-maintenance' }}">
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <button type="button" class="btn btn-sm btn-ppkd-outline"
                                    onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}', {{ $user->is_active ? 1 : 0 }})">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('users.destroy', $user) }}"
                                      onsubmit="return confirm('Hapus karyawan {{ $user->name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm" style="background:#fee2e2;color:#991b1b;border:none;border-radius:8px;">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add / Edit User -->
    <div class="col-lg-4">
        <!-- Add New -->
        <div class="card mb-3">
            <div class="card-header"><i class="bi bi-person-plus-fill me-2 text-success"></i>Tambah Karyawan</div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select">
                            <option value="receptionist">Resepsionis</option>
                            <option value="administrator">Administrator</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-ppkd w-100">Tambah Karyawan</button>
                </form>
            </div>
        </div>

        <!-- Edit User (hidden by default) -->
        <div class="card" id="edit-card" style="display:none;">
            <div class="card-header"><i class="bi bi-pencil-fill me-2 text-success"></i>Edit Karyawan</div>
            <div class="card-body">
                <form method="POST" id="edit-form">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" id="edit-name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="edit-email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru (kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" class="form-control" minlength="6">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" id="edit-role" class="form-select">
                            <option value="receptionist">Resepsionis</option>
                            <option value="administrator">Administrator</option>
                        </select>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_active" id="edit-active" class="form-check-input" value="1">
                        <label class="form-check-label" for="edit-active">Akun Aktif</label>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-ppkd flex-fill">Simpan</button>
                        <button type="button" class="btn btn-ppkd-outline" onclick="document.getElementById('edit-card').style.display='none'">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function editUser(id, name, email, role, isActive) {
    document.getElementById('edit-card').style.display = 'block';
    document.getElementById('edit-form').action = '/users/' + id;
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-email').value = email;
    document.getElementById('edit-role').value = role;
    document.getElementById('edit-active').checked = isActive === 1;
    document.getElementById('edit-card').scrollIntoView({behavior:'smooth'});
}
</script>
@endpush
