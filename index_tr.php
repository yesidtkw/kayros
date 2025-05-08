
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Transacciones | KAYROS</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
<nav style="background:#0073e6;color:white;padding:15px 20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;">

    <div style="flex: 1; display:flex; align-items:center; gap:10px;">
      <img src="logo_kayros.png" alt="Logo Kayros" style="height:40px;">
      <span style="font-size:20px;font-weight:bold;">KAYROS</span>
    </div>
    <div style="flex: 2; text-align:center; font-weight:bold; font-size:16px; flex-wrap:wrap;">
      Tienda Portátiles Celulares y Tablets
    </div>

    <div style="display:flex;gap:15px;flex-wrap:wrap;">
      <a href="#" style="color:white;text-decoration:none;">Inicio</a>
      <a href="#productos" style="color:white;text-decoration:none;">Productos</a>
      <a href="#contacto" style="color:white;text-decoration:none;">Contacto</a>
    </div>
  </nav>
  <h1>Transacciones</h1>

  
  <div style="display:flex;gap:10px;flex-wrap:nowrap;flex-direction:row;align-items:center;justify-content:center;margin-bottom:20px;justify-content:center;">
    <input type="text" id="filtroCliente" placeholder="Buscar cliente">
    <input type="text" id="filtroProducto" placeholder="Buscar producto">
    <input type="date" id="filtroFecha" placeholder="Fecha">
    <button onclick="limpiarFiltros()" style="padding:10px;background:#0073e6;color:#fff;border:none;border-radius:6px;">Limpiar filtros</button>
  </div>

<form id="formulario">
    <input type="hidden" id="id">
    <input type="text" id="cliente_nombre" placeholder="Cliente" required>
    <input type="text" id="telefono" placeholder="Teléfono" required>
    <input type="text" id="producto_nombre" placeholder="Producto" required>
    <input type="number" id="cantidad" placeholder="Cantidad" required>
    <input type="number" id="valor" placeholder="Valor total" required>
    <input type="text" id="tipo_venta" placeholder="Tipo de venta">
    <input type="text" id="dueno" placeholder="Dueño del producto">
    <input type="text" id="estado" placeholder="Estado">
    <textarea id="observaciones" placeholder="Observaciones"></textarea>
    <button type="submit" class="guardar">Guardar</button>
  </form>

  <h2>Listado</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th><th>Fecha</th><th>Cliente</th><th>Teléfono</th><th>Producto</th>
        <th>Cantidad</th><th>Valor</th><th>Tipo Venta</th><th>Dueño</th><th>Estado</th><th>Obs</th><th>Acciones</th>
      </tr>
    </thead>
    <tbody id="tabla">
      <!-- JS llena esta tabla -->
    </tbody>
  </table>

  <script>
    const form = document.getElementById("formulario");
    const tabla = document.getElementById("tabla");

    const limpiarFormulario = () => {
      form.reset();
      form.id.value = "";
    };

    const filtroCliente = document.getElementById("filtroCliente");
    const filtroProducto = document.getElementById("filtroProducto");
    const filtroFecha = document.getElementById("filtroFecha");

    function limpiarFiltros() {
      filtroCliente.value = "";
      filtroProducto.value = "";
      filtroFecha.value = "";
      cargarDatos();
    }

    const cargarDatos = () => {
      fetch("api_tr.php")
        .then(res => res.json())
        .then(data => {
          tabla.innerHTML = "";
          
          data.filter(tr => {
            return (!filtroCliente.value || tr.cliente_nombre.toLowerCase().includes(filtroCliente.value.toLowerCase())) &&
                   (!filtroProducto.value || tr.producto_nombre.toLowerCase().includes(filtroProducto.value.toLowerCase())) &&
                   (!filtroFecha.value || tr.fecha.startsWith(filtroFecha.value));
          }).forEach(tr => {

            const row = document.createElement("tr");
            row.innerHTML = `
              <td>${tr.id}</td>
              <td>${tr.fecha}</td>
              <td>${tr.cliente_nombre}</td>
              <td>${tr.telefono}</td>
              <td>${tr.producto_nombre}</td>
              <td>${tr.cantidad}</td>
              <td>$${parseFloat(tr.valor).toLocaleString("es-CO")}</td>
              <td>${tr.tipo_venta}</td>
              <td>${tr.dueno}</td>
              <td>${tr.estado}</td>
              <td>${tr.observaciones}</td>
              <td>
                <button onclick='editar(${JSON.stringify(tr)})' class="editar">✏️</button>
                <button onclick='eliminar(${tr.id})' class="eliminar">🗑️</button>
              </td>
            `;
            tabla.appendChild(row);
          });
        });
    };

    const editar = (tr) => {
      for (let campo in tr) {
        if (form[campo]) form[campo].value = tr[campo];
      }
    };

    const eliminar = (id) => {
      if (confirm("¿Eliminar esta transacción?")) {
        fetch("api_tr.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ accion: "eliminar", id })
        }).then(() => cargarDatos());
      }
    };

    form.addEventListener("submit", e => {
      e.preventDefault();
      const datos = {
        accion: form.id.value ? "editar" : "crear"
      };
      [...form.elements].forEach(el => {
        if (el.name || el.id) datos[el.name || el.id] = el.value;
      });

      fetch("api_tr.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(datos)
      }).then(() => {
        limpiarFormulario();
        cargarDatos();
      });
    });

    cargarDatos();
  </script>
<footer style="background:#d4edda;text-align:center;padding:20px;" id="contacto" style="background:#1c1c1c;color:#eee;padding:20px;text-align:center;margin-top:40px;">
    <p><strong>Dirección:</strong> Calle 123, Ciudad Ejemplo</p>
    <p><strong>Teléfono:</strong> +57 300 123 4567</p>
    <p><strong>Email:</strong> contacto@tenoplus.com</p>
    <p style="font-size:13px;color:#aaa;">&copy; 2025 TenoPlus. Todos los derechos reservados.</p>
    <div style="margin-top:15px;">
      <a href="#" title="Facebook" style="margin:0 10px;color:#ccc;font-size:20px;">📘</a>
      <a href="#" title="Instagram" style="margin:0 10px;color:#ccc;font-size:20px;">📷</a>
      <a href="#" title="WhatsApp" style="margin:0 10px;color:#ccc;font-size:20px;">💬</a>
    </div>
    <div style="margin-top:10px;">
      <a href="#" onclick="window.scrollTo({top: 0, behavior: 'smooth'});" style="color:#aaa;font-size:14px;">↑ Volver arriba</a>
    </div>
  </footer>
</body>
</html>
