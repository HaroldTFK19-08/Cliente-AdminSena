{{-- Campos de crear y editar instructor: datos del usuario + datos del instructor --}}
@php
    $instructor = $instructor ?? [];
    $usuario = data_get($instructor, 'user', []);
    $editando = (bool) data_get($instructor, 'id');
@endphp

<div class="space-y-7">
    {{-- Datos del usuario (tabla users) --}}
    <section class="seccion">
        <div>
            <h3 class="seccion-titulo">Datos personales</h3>
            <p class="seccion-ayuda">Como aparecen en el documento.</p>
        </div>
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="nombre_1" class="etiqueta">Primer nombre</label>
                <input type="text" id="nombre_1" name="nombre_1" @error('nombre_1') aria-invalid="true" @enderror required maxlength="20" class="campo"
                    value="{{ old('nombre_1', data_get($usuario, 'nombre_1')) }}">
            </div>
            <div>
                <label for="nombre_2" class="etiqueta">Segundo nombre</label>
                <input type="text" id="nombre_2" name="nombre_2" @error('nombre_2') aria-invalid="true" @enderror maxlength="20" class="campo"
                    value="{{ old('nombre_2', data_get($usuario, 'nombre_2')) }}">
            </div>
            <div>
                <label for="apellido_1" class="etiqueta">Primer apellido</label>
                <input type="text" id="apellido_1" name="apellido_1" @error('apellido_1') aria-invalid="true" @enderror required maxlength="20" class="campo"
                    value="{{ old('apellido_1', data_get($usuario, 'apellido_1')) }}">
            </div>
            <div>
                <label for="apellido_2" class="etiqueta">Segundo apellido</label>
                <input type="text" id="apellido_2" name="apellido_2" @error('apellido_2') aria-invalid="true" @enderror maxlength="20" class="campo"
                    value="{{ old('apellido_2', data_get($usuario, 'apellido_2')) }}">
            </div>
            <div>
                <label for="tipo_identificacion" class="etiqueta">Tipo de documento</label>
                <select id="tipo_identificacion" name="tipo_identificacion" @error('tipo_identificacion') aria-invalid="true" @enderror required class="campo">
                    @foreach (['CC', 'TI', 'CE', 'PPT'] as $tipo)
                        <option value="{{ $tipo }}" @selected(old('tipo_identificacion', data_get($usuario, 'tipo_identificacion')) === $tipo)>{{ $tipo }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="identificacion" class="etiqueta">Número de documento</label>
                <input type="text" id="identificacion" name="identificacion" @error('identificacion') aria-invalid="true" @enderror required class="campo"
                    value="{{ old('identificacion', data_get($usuario, 'identificacion')) }}">
            </div>
            <div class="sm:col-span-2">
                <label for="email" class="etiqueta">Correo electrónico</label>
                <input type="email" id="email" name="email" @error('email') aria-invalid="true" @enderror required class="campo"
                    value="{{ old('email', data_get($usuario, 'email')) }}">
            </div>
            <div>
                <label for="password" class="etiqueta">Contraseña</label>
                <input type="password" id="password" name="password" @error('password') aria-invalid="true" @enderror minlength="8" class="campo" {{ $editando ? '' : 'required' }}>
                <p class="ayuda">{{ $editando ? 'Déjala vacía para no cambiarla.' : 'Mínimo 8 caracteres.' }}</p>
            </div>
            <div>
                <label for="password_confirmation" class="etiqueta">Repite la contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" @error('password_confirmation') aria-invalid="true" @enderror minlength="8" class="campo" {{ $editando ? '' : 'required' }}>
            </div>
            <div class="sm:col-span-2">
                <label for="foto_perfil" class="etiqueta">Foto de perfil <span class="font-normal text-slate-400">(opcional)</span></label>
                @php $fotoActual = Vista::archivo(data_get($usuario, 'foto_perfil')); @endphp
                <div class="flex items-center gap-4">
                    <span class="avatar h-16 w-16 rounded-2xl text-lg">
                        <img id="vistaFotoPerfil" src="{{ $fotoActual }}" alt="" class="{{ $fotoActual ? '' : 'hidden' }} h-full w-full object-cover">
                        <span class="{{ $fotoActual ? 'hidden' : '' }}">{{ $editando ? Vista::iniciales($usuario) : '' }}<i class="fa-solid fa-camera {{ $editando ? 'hidden' : '' }}"></i></span>
                    </span>
                    <div class="min-w-0 flex-1">
                        <input type="file" id="foto_perfil" name="foto_perfil" data-vista-previa="vistaFotoPerfil" @error('foto_perfil') aria-invalid="true" @enderror accept=".png,.jpg,.jpeg,.webp" class="campo">
                        <p class="ayuda">PNG, JPG o WEBP de máximo 2 MB.{{ $editando ? ' Si no eliges otra, se conserva la actual.' : '' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Datos del instructor (tabla teachers) --}}
    <section class="seccion">
        <div>
            <h3 class="seccion-titulo">Datos del instructor</h3>
            <p class="seccion-ayuda">Área, especialidad, tipo y fechas.</p>
        </div>
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="area_id" class="etiqueta">Área</label>
                <select id="area_id" name="area_id" @error('area_id') aria-invalid="true" @enderror required class="campo">
                    <option value="">Selecciona un área</option>
                    @foreach ($areas ?? [] as $area)
                        <option value="{{ data_get($area, 'id') }}" @selected(old('area_id', data_get($instructor, 'area_id')) == data_get($area, 'id'))>
                            {{ data_get($area, 'nombre') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="tipo_instructor" class="etiqueta">Tipo de instructor</label>
                <select id="tipo_instructor" name="tipo_instructor" @error('tipo_instructor') aria-invalid="true" @enderror required class="campo">
                    @foreach (['Planta', 'Contratista'] as $tipo)
                        <option value="{{ $tipo }}" @selected(old('tipo_instructor', data_get($instructor, 'tipo_instructor')) === $tipo)>{{ $tipo }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-2">
                <label for="especialidad" class="etiqueta">Especialidad</label>
                <input type="text" id="especialidad" name="especialidad" @error('especialidad') aria-invalid="true" @enderror required maxlength="150" class="campo"
                    value="{{ old('especialidad', data_get($instructor, 'especialidad')) }}">
            </div>
            <div>
                <label for="fecha_inicio" class="etiqueta">Fecha de inicio</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" @error('fecha_inicio') aria-invalid="true" @enderror required class="campo"
                    value="{{ old('fecha_inicio', Vista::fechaInput(data_get($instructor, 'fecha_inicio'))) }}">
            </div>
            <div>
                <label for="fecha_fin" class="etiqueta">Fecha de fin <span class="font-normal text-slate-400">(opcional)</span></label>
                <input type="date" id="fecha_fin" name="fecha_fin" @error('fecha_fin') aria-invalid="true" @enderror class="campo"
                    value="{{ old('fecha_fin', Vista::fechaInput(data_get($instructor, 'fecha_fin'))) }}">
            </div>
        </div>
    </section>
</div>
