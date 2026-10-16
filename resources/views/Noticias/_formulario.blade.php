{{-- Campos compartidos por crear y editar noticia --}}
@php
    $noticia = $noticia ?? [];
    $categorias = ['Tecnologia' => 'Tecnología', 'Educacion' => 'Educación', 'Deporte' => 'Deporte', 'Politica' => 'Política', 'Artistica' => 'Artística', 'Diseño' => 'Diseño'];
    $imagenActual = Vista::archivo(data_get($noticia, 'imagen'));
@endphp

<div class="space-y-7">
    <section class="seccion">
        <div>
            <h3 class="seccion-titulo">Contenido</h3>
            <p class="seccion-ayuda">Un título claro y el texto de la noticia.</p>
        </div>
        <div class="space-y-5">
            <div>
                <label for="titulo" class="etiqueta">Título</label>
                <input type="text" id="titulo" name="titulo" value="{{ old('titulo', data_get($noticia, 'titulo')) }}" required
                    maxlength="255" placeholder="Abiertas las inscripciones del segundo semestre" class="campo">
            </div>
            <div>
                <label for="descripcion" class="etiqueta">Texto</label>
                <textarea id="descripcion" name="descripcion" rows="7" maxlength="2000" required class="campo"
                    oninput="document.getElementById('contadorTexto').textContent = this.value.length">{{ old('descripcion', data_get($noticia, 'descripcion')) }}</textarea>
                <p class="ayuda"><span id="contadorTexto">{{ mb_strlen(old('descripcion', data_get($noticia, 'descripcion', ''))) }}</span> de 2000 caracteres.</p>
            </div>
        </div>
    </section>

    <section class="seccion">
        <div>
            <h3 class="seccion-titulo">Clasificación</h3>
            <p class="seccion-ayuda">Quién la publica y en qué estado está.</p>
        </div>
        <div class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="trainingcenter_id" class="etiqueta">Centro de formación</label>
                <select id="trainingcenter_id" name="trainingcenter_id" required class="campo">
                    <option value="">Elige un centro</option>
                    @foreach ($centros ?? [] as $centro)
                        <option value="{{ data_get($centro, 'id') }}" @selected(old('trainingcenter_id', data_get($noticia, 'trainingcenter_id')) == data_get($centro, 'id'))>
                            {{ data_get($centro, 'nombre') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="categoria" class="etiqueta">Categoría</label>
                <select id="categoria" name="categoria" required class="campo">
                    <option value="">Elige una categoría</option>
                    @foreach ($categorias as $valor => $texto)
                        <option value="{{ $valor }}" @selected(old('categoria', data_get($noticia, 'categoria')) === $valor)>{{ $texto }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="estado" class="etiqueta">Estado</label>
                <select id="estado" name="estado" required class="campo">
                    @foreach (['Creado', 'Pendiente', 'Publicado'] as $estado)
                        <option value="{{ $estado }}" @selected(old('estado', data_get($noticia, 'estado', 'Creado')) === $estado)>{{ $estado }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </section>

    <section class="seccion">
        <div>
            <h3 class="seccion-titulo">Imagen y visibilidad</h3>
            <p class="seccion-ayuda">La imagen se muestra como portada de la noticia.</p>
        </div>
        <div class="space-y-5">
            <div class="flex items-center gap-4">
                @if ($imagenActual)
                    <img src="{{ $imagenActual }}" alt="Imagen actual" class="h-16 w-24 shrink-0 rounded-lg object-cover">
                @endif
                <div class="flex-1">
                    <label for="imagen" class="etiqueta">Imagen</label>
                    <input type="file" id="imagen" name="imagen" accept=".png,.jpg,.jpeg,.webp" class="campo">
                    <p class="ayuda">{{ $imagenActual ? 'Si no eliges otra se conserva la actual.' : 'PNG, JPG o WEBP de máximo 2 MB.' }}</p>
                </div>
            </div>
            <input type="hidden" name="publicada" value="0">
            <label class="opcion">
                <input type="checkbox" name="publicada" value="1" class="casilla" @checked(old('publicada', data_get($noticia, 'publicada')))>
                <span>
                    <span class="block font-medium text-azul-900">Mostrar en el sitio público</span>
                    <span class="block text-xs text-slate-500">Aparecerá en la sección de noticias de la portada.</span>
                </span>
            </label>
        </div>
    </section>
</div>
