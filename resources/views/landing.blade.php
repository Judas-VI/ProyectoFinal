<x-layaout class="fondo-landing vh-100 overflow-hidden">
  <x-navbar/>
  <h1 class="text-center mt-5">Bienvenido a nuestra tienda</h1>
  <class="d-flex justify-content-center align-items-center vh-100">
    <div class="w-100 d-flex justify-content-center align-items-center" style="height:50vh;">
      <a href="{{ url('/stock') }}"
         class="btn btn-primary btn-lg text-white px-5 py-3 shadow rounded-pill"
         style="font-weight:600; background: linear-gradient(90deg,#0069d9,#6610f2); border: none;">
        Explorar Productos
      </a>
    </div>
  </class>
</x-layaout>
<style>

/* Cambiar color del botón que va a stock */
a[href*="/stock"] {
  background: linear-gradient(90deg, #c203fc, #3a054a) !important; 
  color: #fff !important;
  border: none !important;
  box-shadow: 0 6px 18px rgba(0,0,0,0.12) !important;
}

/* Efecto hover */
a[href*="/stock"]:hover {
  background: linear-gradient(90deg, #6610f2, #3a054a) !important;
  transform: translateY(-2px);
  transition: all 150ms ease;
}
</style>