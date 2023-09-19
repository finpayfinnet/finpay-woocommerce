// polyfill for '.closest'
if (!Element.prototype.matches) {
  Element.prototype.matches =
    Element.prototype.msMatchesSelector ||
    Element.prototype.webkitMatchesSelector;
}
if (!Element.prototype.closest) {
  Element.prototype.closest = function(s) {
    var el = this;

    do {
      if (Element.prototype.matches.call(el, s)) return el;
      el = el.parentElement || el.parentNode;
    } while (el !== null && el.nodeType === 1);
    return null;
  };
}

function finpayCheckAndToggleEnvFieldDisplay(trOriginalDisplayValue) {
    // needed to properly restore element visibility after hiding via style.display
    var trOriginalDisplayValue = trOriginalDisplayValue || 'table-row';

    // hide all (sandbox & production) env fields
    var allFinpayEnvFieldEl = document.querySelectorAll('.toggle-finpay');
    for (var i = allFinpayEnvFieldEl.length - 1; i >= 0; i--) {
        allFinpayEnvFieldEl[i]
            .closest('tr')
            .style.display = 'none'; // hide
    }

    // then show only active env fields
    var finpayActiveEnv = (document.querySelector("select[name*='finpay_environment']")).value;
    var finpayActiveEnvElClass = finpayActiveEnv + '_settings';
    var allFinpayActiveEnvFieldEl = document.querySelectorAll('.' + finpayActiveEnvElClass);
    for (var i = allFinpayActiveEnvFieldEl.length - 1; i >= 0; i--) {
        allFinpayActiveEnvFieldEl[i]
            .closest('tr')
            .style.display = trOriginalDisplayValue; // show
    }
}

function finpayHide3dsField(){
    document.querySelector('#woocommerce_finpay_subscription_enable_3d_secure')
        .closest('tr')
        .style.display = 'none'; // hide
}
function finpayHideSavecardField(){
    document.querySelector('#woocommerce_finpay_subscription_enable_savecard')
        .closest('tr')
        .style.display = 'none'; // hide
}

// Main script that will be executed on page load
document.addEventListener("DOMContentLoaded", function(event) {
	console.log('custom script loaded');
    // execute only if element detected
    var finpayEnvFieldEl = document.querySelector("select[name*='finpay_environment']");
    console.log('isinya: ',finpayEnvFieldEl);
    if(finpayEnvFieldEl){
        // get `tr` element CSS display original value
        var trOriginalDisplayValue = finpayEnvFieldEl.closest('tr').style.display;
        finpayCheckAndToggleEnvFieldDisplay(trOriginalDisplayValue);
        finpayEnvFieldEl.addEventListener('change', function() {
            finpayCheckAndToggleEnvFieldDisplay(trOriginalDisplayValue);
        });

        // Hide 3ds and save card field on finpay subscription admin settings
        if ( document.querySelectorAll('[id*=woocommerce_finpay_subscription]').length > 0) {
            finpayHideSavecardField();
            finpayHide3dsField();
        }
    }
});