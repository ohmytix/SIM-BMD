<div class="container-fluid">

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h6 class="mb-3">
                {{ $isEdit ? 'Edit User' : 'Tambah User' }}
            </h6>

            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'create' }}">
                <div class="row g-2">

                    <div class="col-md-3">
                        <input type="text"
                               wire:model.defer="name"
                               class="form-control"
                               placeholder="Nama">

                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <input type="email"
                               wire:model.defer="email"
                               class="form-control"
                               placeholder="Email">

                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- ROLE --}}
                    <div class="col-md-2">
                        <select wire:model.live="role" class="form-select">

                            <option value="admin">Admin</option>

                            <option value="operator_skpd">
                                Operator SKPD
                            </option>

                            <option value="viewer">
                                Viewer
                            </option>

                        </select>

                        @error('role')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- SKPD --}}
                    <div class="col-md-2">

                        <select wire:model.defer="skpd_id"
                                class="form-select"
                                {{ $role !== 'operator_skpd' ? 'disabled' : '' }}>

                            <option value="">
                                Pilih SKPD
                            </option>

                            @foreach($this->skpds as $skpd)

                                <option value="{{ $skpd->id }}">
                                    {{ $skpd->nama }}
                                </option>

                            @endforeach

                        </select>

                        @error('skpd_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                    </div>

                    {{-- PASSWORD --}}
                    <div class="col-md-2">
                        <input type="password"
                               wire:model.defer="password"
                               class="form-control"
                               placeholder="{{ $isEdit ? 'Password (opsional)' : 'Password' }}">
                    </div>

                    <div class="col-md-2 d-flex gap-2">

                        <button class="btn btn-primary btn-sm">
                            {{ $isEdit ? 'Update' : 'Simpan' }}
                        </button>

                        @if($isEdit)
                            <button type="button"
                                    wire:click="resetForm"
                                    class="btn btn-secondary btn-sm">
                                Batal
                            </button>
                        @endif

                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <h6 class="mb-3">Daftar User</h6>

            <table class="table table-sm">

                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>SKPD</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($users as $u)

                        <tr>

                            <td>{{ $u->name }}</td>

                            <td>{{ $u->email }}</td>

                            <td>
                                {{ ucfirst(str_replace('_', ' ', $u->role)) }}
                            </td>

                            <td>
                                {{ $u->skpd->nama ?? '-' }}
                            </td>

                            <td>

                                <button wire:click="edit({{ $u->id }})"
                                        class="btn btn-warning btn-sm">
                                    Edit
                                </button>

                                <button wire:click="delete({{ $u->id }})"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus user ini?')">
                                    Hapus
                                </button>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>
    </div>

</div>