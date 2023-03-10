@section('head.title', 'Perfil')
@section('page.title', "Perfil do usuário {$user->name}")

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label @error('user.name') is-invalid @enderror">Nome</label>
                    <div class="col-md-10">
                        <input class="form-control @error('user.name') is-invalid @enderror" placeholder="Antonio" wire:model="user.name">
                        @error('user.name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label @error('user.email') is-invalid @enderror">Email</label>
                    <div class="col-md-10">
                        <input class="form-control @error('user.email') is-invalid @enderror" placeholder="Galpão I" wire:model="user.email">
                        @error('user.email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label @error('user.password') is-invalid @enderror">Senha</label>
                    <div class="col-md-10">
                        <input class="form-control @error('user.password') is-invalid @enderror" placeholder="******" wire:model="user.password">
                        @error('user.password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label">Perfil</label>
                    <div class="col-md-10">
                        <select class="form-select @error('user.role_id') is-invalid @enderror" @if($user->id == auth()->user()->id) disabled @endif wire:model="user.role_id">
                            <option>Selecione</option>
                            @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->title}}</option>
                            @endforeach
                        </select>
                        @error('user.role_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row text-center mt-4">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary w-md">Atualizar</button>
                        <a href="{{route('users.index')}}" class="btn btn-danger w-md">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>