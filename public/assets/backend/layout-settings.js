(function () {
	"use strict";
	$(document).ready(function () {
		// Store object for local storage data
		var currentOptions = {
			themeVariation: "minimal-theme",
			headerColor: " ",
		};

		/**
		 * Get local storage value
		 */
		function getOptions() {
			return JSON.parse(localStorage.getItem("optionsObject"));
		}

		/**
		 * Set local storage property value
		 */
		function setOptions(propertyName, propertyValue) {
			//Store in local storage
			var optionsCopy = Object.assign({}, currentOptions);
			optionsCopy[propertyName] = propertyValue;

			//Store in local storage
			localStorage.setItem("optionsObject", JSON.stringify(optionsCopy));
		}

		if (getOptions() != null) {
			currentOptions = getOptions();
		} else {
			localStorage.setItem("optionsObject", JSON.stringify(currentOptions));
		}

		/**
		 * Clear local storage
		 */
		function clearOptions() {
			localStorage.removeItem("optionsObject");
		}

		// Set localstorage value to variable
		if (getOptions() != null) {
			currentOptions = getOptions();
		} else {
			localStorage.setItem("optionsObject", JSON.stringify(currentOptions));
		}

		// Theme Color
		var theme_minimal = jQuery("#MinimalTheme");
		var theme_light = jQuery("#LightTheme");
		var theme_dark = jQuery("#DarkTheme");
		var theme_semidark = jQuery("#SemiDarkTheme");

    ///minimal theme
		theme_minimal.click(function () {
			"use strict";
			jQuery(this).attr("checked",true);
			theme_light.attr("checked",false);
			theme_dark.attr("checked",false);
			theme_semidark.attr("checked",false);
      jQuery("html").attr("class", "minimal-theme")
			//Store in local storage
			setOptions("themeVariation", "minimal-theme");
		});
		//Click for current options
		if (currentOptions.themeVariation === "minimal-theme") {
			theme_minimal.trigger("click");
		}

    ///light theme
		theme_light.click(function () {
			"use strict";
			jQuery(this).attr("checked",true);
			theme_minimal.attr("checked",false);
      theme_dark.attr("checked",false);
			theme_semidark.attr("checked",false);
      jQuery("html").attr("class", "light-theme")
			//Store in local storage
			setOptions("themeVariation", "light-theme");
		});
		//Click for current options
		if (currentOptions.themeVariation === "light-theme") {
			theme_light.trigger("click");
		}

    ///dark theme
		theme_dark.click(function () {
			"use strict";
			jQuery(this).attr("checked",true);
			theme_minimal.attr("checked",false);
      theme_light.attr("checked",false);
			theme_semidark.attr("checked",false);
      jQuery("html").attr("class", "dark-theme")
			//Store in local storage
			setOptions("themeVariation", "dark-theme");
		});
		//Click for current options
		if (currentOptions.themeVariation === "dark-theme") {
			theme_dark.trigger("click");
		}
    ///semi-dark theme
		theme_semidark.click(function () {
			"use strict";
			jQuery(this).attr("checked",true);
			theme_minimal.attr("checked",false);
      theme_light.attr("checked",false);
			theme_dark.attr("checked",false);
      jQuery("html").attr("class", "semi-dark")
			//Store in local storage
			setOptions("themeVariation", "semi-dark");
		});
		//Click for current options
		if (currentOptions.themeVariation === "semi-dark") {
			theme_semidark.trigger("click");
		}

    // header color option

    $("#headercolor1").on("click", function() {
      $("html").addClass("color-header headercolor1"), $("html").removeClass("headercolor2 headercolor3 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8")
      setOptions("headerColor", "headercolor1");
    });
    //Click for current options
		if (currentOptions.headerColor === "headercolor1") {
      $("#headercolor1").trigger("click");
		}
    $("#headercolor2").on("click", function() {
      $("html").addClass("color-header headercolor2"), $("html").removeClass("headercolor1 headercolor3 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8")
      setOptions("headerColor", "headercolor2");
    });
    //Click for current options
		if (currentOptions.headerColor === "headercolor2") {
      $("#headercolor2").trigger("click");
		}
    $("#headercolor3").on("click", function() {
      $("html").addClass("color-header headercolor3"), $("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8")
      setOptions("headerColor", "headercolor3");
    });
    //Click for current options
		if (currentOptions.headerColor === "headercolor3") {
      $("#headercolor3").trigger("click");
		}
    $("#headercolor4").on("click", function() {
      $("html").addClass("color-header headercolor4"), $("html").removeClass("headercolor1 headercolor2 headercolor3 headercolor5 headercolor6 headercolor7 headercolor8")
      setOptions("headerColor", "headercolor4");
    });
    //Click for current options
		if (currentOptions.headerColor === "headercolor4") {
      $("#headercolor4").trigger("click");
		}
    $("#headercolor5").on("click", function() {
      $("html").addClass("color-header headercolor5"), $("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor3 headercolor6 headercolor7 headercolor8")
      setOptions("headerColor", "headercolor5");
    });
    //Click for current options
		if (currentOptions.headerColor === "headercolor5") {
      $("#headercolor5").trigger("click");
		}
    $("#headercolor6").on("click", function() {
      $("html").addClass("color-header headercolor6"), $("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor5 headercolor3 headercolor7 headercolor8")
      setOptions("headerColor", "headercolor6");
    });
    //Click for current options
		if (currentOptions.headerColor === "headercolor6") {
      $("#headercolor6").trigger("click");
		}
    $("#headercolor7").on("click", function() {
      $("html").addClass("color-header headercolor7"), $("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor3 headercolor8")
      setOptions("headerColor", "headercolor7");
    });
    //Click for current options
		if (currentOptions.headerColor === "headercolor7") {
      $("#headercolor7").trigger("click");
		}
    $("#headercolor8").on("click", function() {
      $("html").addClass("color-header headercolor8"), $("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor7 headercolor3")
      setOptions("headerColor", "headercolor8");
    })
    //Click for current options
		if (currentOptions.headerColor === "headercolor8") {
      $("#headercolor8").trigger("click");
		}
    // reset all settings
    $("#reset-settings").click(function () {
			clearOptions();
			location.reload();
		});

	});

  $(document).ready(function(){
    $('#accordion .card .card-link').click(function(){
      if($(this).find("i.fa").hasClass("fa-minus"))
      {
        $(this).find("i.fa").removeClass("fa-minus");
        $(this).find("i.fa").addClass("fa-plus");
      } else if($(this).find("i.fa").hasClass("fa-plus"))
      {
        $(this).find("i.fa").removeClass("fa-plus");
        $(this).find("i.fa").addClass("fa-minus");
      }
      $(this).parents(".card").siblings().find(".card-header .card-link i.fa").removeClass("fa-minus");
      $(this).parents(".card").siblings().find(".card-header .card-link i.fa").addClass("fa-plus");
    });
  });
})();
