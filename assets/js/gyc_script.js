(function($){
    $(document).ready(function(){

        var gaugeType = $('.speed_gauge').data('gaugetype');
        if(gaugeType !== '4'){
            $('.checkreserve').append('<div class="reserve_gauge_meter" id="reserve_gauge_meter"></div>');
        }

        if(gaugeType == '1'){
            gauge_one();
        }
        // else if(gaugeType == '2'){
        //     gauge_two();
        // }else if(gaugeType == '3'){
        //     gauge_three();
        // }
        else if(gaugeType == '4'){
            gauge_four();
        }

        // gauge 4 
        function gauge_four(){
            class GaugeChart {
                constructor(element, params) {
                  this._element = element;
                  this._initialValue = params.initialValue;
                  this._higherValue = params.higherValue;
                  this._title = params.title;
                  this._subtitle = params.subtitle;
                }
            
                _buildConfig() {
                  let element = this._element;

                  var priceReserved = $('.speed_gauge').data('reserveprice');
                    var ext_price = priceReserved * 1.5;
                    // console.log(ext_price);
            
                  return {
                    value: this._initialValue,
                    valueIndicator: {
                      color: '#fff' },
            
                    geometry: {
                      startAngle: 180,
                      endAngle: 360 },
            
                    scale: {
                      startValue: 0,
                      endValue: this._higherValue,
                      customTicks: [0, priceReserved * .25, priceReserved * .5, priceReserved * .75, priceReserved, priceReserved * 1.25, priceReserved * 1.5],
                      tick: {
                        length: 7 },
            
                      label: {
                        font: {
                          color: '#87959f',
                          size: 14,
                          family: '"Open Sans", sans-serif' } } },
            
            
            
                    title: {
                      verticalAlignment: 'bottom',
                      text: this._title,
                      font: {
                        family: '"Open Sans", sans-serif',
                        color: 'gray',
                        size: 16 },
            
                      subtitle: {
                        text: this._subtitle,
                        font: {
                          family: '"Open Sans", sans-serif',
                          color: 'gray',
                          weight: 700,
                          size: 28 } } },
            
            
            
                    onInitialized: function () {
                      let currentGauge = $(element);
                      let circle = currentGauge.find('.dxg-spindle-hole').clone();
                      let border = currentGauge.find('.dxg-spindle-border').clone();
            
                      currentGauge.find('.dxg-title text').first().attr('y', 48);
                      currentGauge.find('.dxg-title text').last().attr('y', 28);
                      currentGauge.find('.dxg-value-indicator').append(border, circle);
                    } };
                }
            
                init() {
                  $(this._element).dxCircularGauge(this._buildConfig());
                }}


            
            // console.log(ext_price);
            var met_text = $('.speed_gauge').data('met');
            $('.checkreserve').append('<div class="gauge" style="background:#000;"></div>');
            var priceReserved = $('.speed_gauge').data('reserveprice');
                var ext_price = priceReserved * 1.5;
            $('#reserve_gauge_meter').remove();

            $('#uwa_bid_value').on('click change input cut copy paste click keyup', function(){
                var bidValue = $(this).val();
                $('.gauge').each(function (index, item) {
                    let params = {
                        initialValue: bidValue,
                        higherValue: ext_price,
                        title: met_text,
                        subtitle: '&nbsp;' };
    
                let gauge = new GaugeChart(item, params);
                    gauge.init();
                });

            });


            $('.gauge').each(function (index, item) {
            let params = {
                initialValue: 0,
                higherValue: ext_price,
                title: met_text,
                subtitle: '&nbsp;' };

            let gauge = new GaugeChart(item, params);
                gauge.init();
            });


            
        }

        // // Gauge 3
        // function gauge_three(){
        //     var priceReserved = $('.speed_gauge').data('reserveprice');
        //     $('.reserve_gauge_meter').gauge({
        //         values: {
        //             0 : '0',
        //             15: priceReserved * .3,
        //             30: priceReserved * .6,
        //             50: priceReserved,
        //             80: priceReserved * 1.6,
        //             100: priceReserved * 2
        //         },
        //         colors: {
        //             0 : '#FF0000',
        //             9 : '#FFA500',
        //             60: '#FFA500',
        //             80: '#378618'
        //         },
        //         angles: [
        //             180,
        //             360
        //         ],
        //         lineWidth: 10,
        //         arrowWidth: 20,
        //         arrowColor: '#ccc',
        //         inset:true,

        //         value: 80
        //     });

        //     $('#uwa_bid_value').on('change cut copy paste click keyup', function(){
    
        //         var bidValue = $(this).val();
        //         var priceReserved = $('.speed_gauge').data('reserveprice');


        //         $('.reserve_gauge_meter').gauge({
        //             values: {
        //                 0 : '0',
        //                 15: priceReserved * .3,
        //                 30: priceReserved * .6,
        //                 50: priceReserved,
        //                 80: priceReserved * 1.6,
        //                 100: priceReserved * 2
        //             },
        //             colors: {
        //                 0 : '#FF0000',
        //                 9 : '#FFA500',
        //                 60: '#FFA500',
        //                 80: '#378618'
        //             },
        //             angles: [
        //                 180,
        //                 360
        //             ],
        //             lineWidth: 10,
        //             arrowWidth: 20,
        //             arrowColor: '#ccc',
        //             inset:true,

        //             value: bidValue * 2
        //         });

        //     });
        // }

        // // Gauge 2 
        // function gauge_two(){
        //     let gauge1Options = {
        //         animated: true,
        //         backgroundColor: "rgba(0,0,0, 0.7)",
        //         barHeight: "24px",
        //         barRadius: 4,
        //         boldLabels: false,
        //         duration: 1000,
        //         fillBackgroundColor: "linear-gradient(90deg,  #E6462C 50%, #FFC017 90%, #39C85F 100%)",
        //         fillRadius: 4,
        //         fillSize: "20px",
        //         labelAlignment: "center",
        //         labelColor: "#555",
        //         labelFontSize: 14,
        //         labelPosition: "top",
        //         labelUnit: "%",
        //         showLabel: true,
        //         showTitle: true,
        //         title: "Sales Target",
        //         titleColor: "#555",
        //         titleFontSize: null,
        //         type: "line",
        //         value: 75,
        //         width: "100%"
        //     }
        //     $("#reserve_gauge_meter").JsProgressGauge(gauge1Options)
        // }

        // Gauge 1 
        function gauge_one(){
            var priceReserved = $('.speed_gauge').data('reserveprice');
            var ext_price = priceReserved * 1.5;
            var met_text = $('.speed_gauge').data('met');
    
            $('.reserve_gauge_meter').simpleGauge({
                value: 0,
                min: 0,
                max:ext_price,
                bars: {
                    colors: [
                      [ 0,   '#F80100', 0, 0 ],
                      [ ext_price / 5, '#F36A55', 0, 0 ],
                      [ ext_price / 2, '#FFA000', 0, 0 ],
                      [ priceReserved, '#378618', 0, 0 ],
                      [ ext_price, '#378618', 0, 0 ]
                    ]
                },
                title: {
                    text: met_text,
                    style: 'color: gray; font-size: 20px; padding: 0px;'
                },
            });
    
            $('#uwa_bid_value').on('click change input cut copy paste click keyup', function(){
    
                var bidValue = $(this).val();
                
                var extendRange = priceReserved * 1.5;
                $('.reserve_gauge_meter').simpleGauge({
                    value: bidValue,
                    min: 0,
                    max:extendRange,
                    bars: {
                        colors: [
                          [ 0,   '#F80100', 0, 0 ],
                          [ extendRange / 5, '#F36A55', 0, 0 ],
                          [ extendRange / 2, '#FFA000', 0, 0 ],
                          [ priceReserved, '#378618', 0, 0 ],
                          [ extendRange, '#378618', 0, 0 ]
                        ]
                    },
                    title: {
                        text: met_text,
                        style: 'color: gray; font-size: 20px; padding: 0px;'
                    },
                });
            });
    
        }


        
        



        
    });
})(jQuery);


