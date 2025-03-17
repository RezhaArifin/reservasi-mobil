<div class="col-sm-12 col-xl-6">
    <div class="bg-light rounded h-100 p-4">
        <h6 class="mb-4">Add users</h6>
        <form>
            <div class="mb-3">
                <label for="email" class="form-label">Nama</label>
                <input type="text" class="form-control" wire:model="nama" id="nama" value="{{ @old('nama') }}">
                @error('nama')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="text" class="form-control" wire:model="email" id="email" value="{{ @old('email') }}">
                @error('email')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" wire:model="password" id="password" value="{{ @old('password') }}">
                    @error('password')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Sebagai</label>
                    <select id="role" class="form select" wire:model="role">
                        <option value="">--Pilih--</option>
                        <option value="admin">admin</option>
                    </select>
                    @error('role')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="button" wire:click="store" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
