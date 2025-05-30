document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("form-producto");
  const bodegaSelect = document.getElementById("bodega");
  const sucursalSelect = document.getElementById("sucursal");
  const monedaSelect = document.getElementById("moneda");

  // Cargar bodegas y monedas al inicio
  fetch("cargar_datos.php?tipo=bodegas")
    .then((res) => res.json())
    .then((data) => {
      data.forEach((bodega) => {
        const option = document.createElement("option");
        option.value = bodega.id;
        option.textContent = bodega.nombre;
        bodegaSelect.appendChild(option);
      });
    });

  fetch("cargar_datos.php?tipo=monedas")
    .then((res) => res.json())
    .then((data) => {
      data.forEach((moneda) => {
        const option = document.createElement("option");
        option.value = moneda.id;
        option.textContent = moneda.nombre;
        monedaSelect.appendChild(option);
      });
    });

  // Cargar sucursales al cambiar bodega
  bodegaSelect.addEventListener("change", () => {
    const bodegaId = bodegaSelect.value;
    sucursalSelect.disabled = !bodegaId;

    if (bodegaId) {
      fetch(`cargar_datos.php?bodega_id=${bodegaId}`)
        .then((res) => res.json())
        .then((data) => {
          sucursalSelect.innerHTML = '<option value="">Seleccione...</option>';
          data.forEach((sucursal) => {
            const option = document.createElement("option");
            option.value = sucursal.id;
            option.textContent = sucursal.nombre;
            sucursalSelect.appendChild(option);
          });
        });
    } else {
      sucursalSelect.innerHTML = '<option value="">Seleccione...</option>';
      sucursalSelect.disabled = true;
    }
  });

  // Validación de formulario
  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    let isValid = true;

    // Limpiar errores previos
    document.querySelectorAll(".error").forEach((el) => (el.textContent = ""));

    // Validación de código (regex, unicidad)
    const codigo = document.getElementById("codigo").value.trim();
    if (!codigo) {
      alert("El código del producto no puede estar en blanco.");
      isValid = false;
    } else if (codigo.length < 5 || codigo.length > 15) {
      alert("El código del producto debe tener entre 5 y 15 caracteres.");
      isValid = false;
    } else if (!/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]+$/.test(codigo)) {
      alert("El código del producto debe contener letras y números");
      isValid = false;
    } else {
      // Validación de unicidad del código
      try {
        const response = await fetch(
          "verificar_codigo.php?codigo=" + encodeURIComponent(codigo)
        );

        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        // Verificar si la respuesta contiene un error
        if (data.error) {
          throw new Error(data.error);
        }

        // Verificar unicidad
        if (data.existe) {
          alert("El código del producto ya está registrado.");
          isValid = false;
        }
      } catch (error) {
        console.error("Error al verificar código:", error);
        alert("Error al verificar el código. Detalle: " + error.message);
        isValid = false;
      }
    }

    // Validación de nombre
    const nombre = document.getElementById("nombre").value.trim();
    if (!nombre) {
      alert("El nombre del producto no puede estar en blanco.");
      isValid = false;
    } else if (nombre.length < 2 || nombre.length > 50) {
      alert("El nombre del producto debe tener entre 2 y 50 caracteres.");
      isValid = false;
    }

    // Validación de bodega
    const bodega = bodegaSelect.value;
    if (!bodega) {
      alert("Debe seleccionar una bodega.");
      isValid = false;
    }

    // Validación de sucursal
    const sucursal = sucursalSelect.value;
    if (!sucursal) {
      alert("Debe seleccionar una sucursal para la bodega seleccionada.");
      isValid = false;
    }

    // Validación de moneda
    const moneda = monedaSelect.value;
    if (!moneda) {
      alert("Debe seleccionar una moneda para el producto.");
      isValid = false;
    }

    // Validación de precio (regex)
    const precio = document.getElementById("precio").value.trim();
    if (!precio) {
      alert("El precio del producto no puede estar en blanco.");
      isValid = false;
    } else if (!/^\d+(\.\d{1,2})?$/.test(precio)) {
      alert(
        "El precio del producto debe ser un número positivo con hasta dos decimales."
      );
      isValid = false;
    }

    // Validación de materiales
    const materiales = document.querySelectorAll(
      'input[name="material[]"]:checked'
    );
    if (materiales.length < 2) {
      alert("Debe seleccionar al menos dos materiales para el producto.");
      isValid = false;
    }

    // Validación de descripción
    const descripcion = document.getElementById("descripcion").value.trim();
    if (!descripcion) {
      alert("La descripción del producto no puede estar en blanco.");
      isValid = false;
    } else if (descripcion.length < 10 || descripcion.length > 1000) {
      alert(
        "La descripción del producto debe tener entre 10 y 1000 caracteres."
      );
      isValid = false;
    }

    if (isValid) {
      // Enviar por AJAX
      const formData = new FormData(form);
      fetch("guardar_producto.php", {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.status === "success") {
            alert("Producto guardado exitosamente!");
            form.reset();
            // Resetear selects
            sucursalSelect.innerHTML =
              '<option value="">Seleccione...</option>';
            sucursalSelect.disabled = true;
          } else {
            alert("Error: " + data.message);
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          alert("Error al guardar el producto. Intente nuevamente.");
        });
    }
  });

  // Función para mostrar errores
  function showError(elementId, message) {
    const errorElement = document.getElementById(elementId);
    if (errorElement) {
      errorElement.textContent = message;
    }
  }
});
