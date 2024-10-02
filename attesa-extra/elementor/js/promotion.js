(function($) {
    'use strict';
	$(window).on("elementor/frontend/init", function() {
		if (elementorFrontend.isEditMode()) {
			
			parent.document.addEventListener("mousedown", function (e) {
				
				var widgets = parent.document.querySelectorAll(".elementor-element--promotion");

				if (widgets.length > 0) {
					widgets.forEach(function(widget) {
						if (widget.contains(e.target)) {
							var dialog = parent.document.querySelector("#elementor-element--promotion__dialog");
							var icon = widget.querySelector(".icon > i");

							if (icon.classList.toString().indexOf("awp-pro-addons") >= 0) {
								dialog.classList.add("is-attesa-box");
								var intDialog = parent.document.querySelector(".is-attesa-box");
								//intDialog.querySelector("button.dialog-buttons-action").style.display = "none";

								if (intDialog.querySelector(".awp-dialog-buttons-action") === null) {
									var button = document.createElement("a");
									var buttonText = document.createTextNode(AttesaExtraElementorPromotion.conversionString);

									button.setAttribute("href", "https://attesawp.com/attesa-pro/");
									button.setAttribute("target", "_blank");
									button.classList.add(
										"dialog-button",
										"dialog-action",
										"dialog-buttons-action",
										"elementor-button",
										"elementor-button-success",
										"awp-dialog-buttons-action"
									);
									button.appendChild(buttonText);

									intDialog.querySelector(".dialog-buttons-action").insertAdjacentHTML("afterend", button.outerHTML);
								} else {
									intDialog.querySelector(".awp-dialog-buttons-action").style.display = "";
								}
							} else {
								dialog.classList.remove("is-attesa-box");
								/*
								dialog.querySelector("button.dialog-buttons-action").style.display = "";
								if (dialog.querySelector(".awp-dialog-buttons-action") !== null) {
									dialog.querySelector(".awp-dialog-buttons-action").style.display = "none";
								}
								*/
							}
						}
					});
				}
			});
		}
	});
}(jQuery));