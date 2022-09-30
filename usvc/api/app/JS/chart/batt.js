/*=============== BATTERY ===============*/
// initBattery()

// function initBattery(){
//     const batteryLiquid = document.querySelector('.battery__liquid'),
//           batteryStatus = document.querySelector('.battery__status'),
//           batteryPercentage = document.querySelector('.battery__percentage')
    
//     navigator.getBattery().then((batt) =>{
//         updateBattery = () =>{
//             /* 1. We update the number level of the battery */
//             let level = Math.floor(batt.level * 100)
//             batteryPercentage.innerHTML = level+ '%'

//             /* 2. We update the background level of the battery */
//             batteryLiquid.style.height = `${parseInt(batt.level * 100)}%`

//             /* 3. We validate full battery, low battery and if it is charging or not */
//             if(level == 100){ /* We validate if the battery is full */
//                 batteryStatus.innerHTML = `Full battery <i class="ri-battery-2-fill green-color"></i>`
//                 batteryLiquid.style.height = '103%' /* To hide the ellipse */
//             }
//             else if(level <= 20 &! batt.charging){ /* We validate if the battery is low */
//                 batteryStatus.innerHTML = `Low battery <i class="ri-plug-line animated-red"></i>`
//             }
//             else if(batt.charging){ /* We validate if the battery is charging */
//                 batteryStatus.innerHTML = `Charging... <i class="ri-flashlight-line animated-green"></i>`
//             }
//             else{ /* If it's not loading, don't show anything. */
//                 batteryStatus.innerHTML = ''
//             }
            
//             /* 4. We change the colors of the battery and remove the other colors */
//             if(level <=20){
//                 batteryLiquid.classList.add('gradient-color-red')
//                 batteryLiquid.classList.remove('gradient-color-orange','gradient-color-yellow','gradient-color-green')
//             }
//             else if(level <= 40){
//                 batteryLiquid.classList.add('gradient-color-orange')
//                 batteryLiquid.classList.remove('gradient-color-red','gradient-color-yellow','gradient-color-green')
//             }
//             else if(level <= 80){
//                 batteryLiquid.classList.add('gradient-color-yellow')
//                 batteryLiquid.classList.remove('gradient-color-red','gradient-color-orange','gradient-color-green')
//             }
//             else{
//                 batteryLiquid.classList.add('gradient-color-green')
//                 batteryLiquid.classList.remove('gradient-color-red','gradient-color-orange','gradient-color-yellow')
//             }
//         }
//         updateBattery()

//         /* 5. Battery status events */
//         batt.addEventListener('chargingchange', () => {updateBattery()})
//         batt.addEventListener('levelchange', () => {updateBattery()})
//     })
// }
// updateBattery(100)
function updateBattery(level){
    // console.log(parseInt(level), typeof(level))
    const BatteryLevel = document.querySelector('#BatteryIcon');
    if(parseInt(level) < 10){
        BatteryLevel.style.color = "#e32467";
        // BatteryLevel.setAttribute( 'style', 'color: red !important' );
        BatteryLevel.innerHTML = " " +level + " %";
        BatteryLevel.classList.add('fa-battery-empty')
        BatteryLevel.classList.remove('fa-battery-quarter','fa-battery-half','fa-battery-three-quarters', 'fa-battery-full')
    }
    else if(parseInt(level) < 40){
        BatteryLevel.style.color = "#e32467";
        // BatteryLevel.setAttribute( 'style', 'color: red !important' );
        BatteryLevel.innerHTML = " " +level + " %";
        BatteryLevel.classList.add('fa-battery-quarter')
        BatteryLevel.classList.remove('fa-battery-empty','fa-battery-half','fa-battery-three-quarters', 'fa-battery-full')
    }
    else if(parseInt(level) < 50){
        BatteryLevel.style.color = "#f5c056";
        // BatteryLevel.setAttribute( 'style', 'color: yellow !important' );
        BatteryLevel.innerHTML = " " +level + " %";
        BatteryLevel.classList.add('fa-battery-half')
        BatteryLevel.classList.remove('fa-battery-empty','fa-battery-quarter','fa-battery-three-quarters', 'fa-battery-full')
    }
    else if(parseInt(level) < 75){
        BatteryLevel.style.color = "#f5c056";
        // BatteryLevel.setAttribute( 'style', 'color: yellow !important' );
        BatteryLevel.innerHTML = " " +level + " %";
        BatteryLevel.classList.add('fa-battery-half')
        BatteryLevel.classList.remove('fa-battery-empty','fa-battery-quarter','fa-battery-three-quarters', 'fa-battery-full')
    }
    else if(parseInt(level) < 90){
        BatteryLevel.style.color = "#f5c056";
        // BatteryLevel.setAttribute( 'style', 'color: yellow !important' );
        BatteryLevel.innerHTML = " " +level + " %";
        BatteryLevel.classList.add('fa-battery-three-quarters')
        BatteryLevel.classList.remove('fa-battery-empty','fa-battery-quarter','fa-battery-half', 'fa-battery-full')        
    }
    else {
        BatteryLevel.style.color = "#7bf268";
        // BatteryLevel.setAttribute( 'style', 'color: green !important' );
        BatteryLevel.innerHTML = " " +level + " %";
        BatteryLevel.classList.add('fa-battery-full')
        BatteryLevel.classList.remove('fa-battery-empty','fa-battery-quarter','fa-battery-half', 'fa-battery-three-quarters')
    }
    // else if(parseInt(level) == 100){
    //     console.log(100)
    //     BatteryLevel.style.color = "green";
    //     // BatteryLevel.setAttribute( 'style', 'color: green !important' );
    //     BatteryLevel.innerHTML = " " +level + " %";
    //     BatteryLevel.classList.add('fa-battery-full')
    //     BatteryLevel.classList.remove('fa-battery-empty','fa-battery-quarter','fa-battery-half', 'fa-battery-three-quarters')
    // }
}
// function updateBattery(level) {
//     /* 1. We update the number level of the battery */
//     const batteryLiquid = document.querySelector('.battery__liquid'),
//         //   batteryStatus = document.querySelector('.battery__status'),
//           batteryPercentage = document.querySelector('.battery__percentage')
//     // let level = Math.floor(battLevel * 100)
//     batteryPercentage.innerHTML = level+ '%'

//     /* 2. We update the background level of the battery */
//     batteryLiquid.style.height = `${level}%`

//     /* 3. We validate full battery, low battery and if it is charging or not */
//     if(level == 100){ /* We validate if the battery is full */
//         // batteryStatus.innerHTML = `Full battery <i class="ri-battery-2-fill green-color"></i>`
//         batteryLiquid.style.height = '103%' /* To hide the ellipse */
//     }
//     // else if(level <= 20 &! batt.charging){ /* We validate if the battery is low */
//     //     batteryStatus.innerHTML = `Low battery <i class="ri-plug-line animated-red"></i>`
//     // }
//     // else if(batt.charging){ /* We validate if the battery is charging */
//     //     batteryStatus.innerHTML = `Charging... <i class="ri-flashlight-line animated-green"></i>`
//     // }
//     // else{ /* If it's not loading, don't show anything. */
//     //     batteryStatus.innerHTML = ''
//     // }
    
//     /* 4. We change the colors of the battery and remove the other colors */
//     if(level <=20){
//         batteryLiquid.classList.add('gradient-color-red')
//         batteryLiquid.classList.remove('gradient-color-orange','gradient-color-yellow','gradient-color-green')
//     }
//     else if(level <= 40){
//         batteryLiquid.classList.add('gradient-color-orange')
//         batteryLiquid.classList.remove('gradient-color-red','gradient-color-yellow','gradient-color-green')
//     }
//     else if(level <= 80){
//         batteryLiquid.classList.add('gradient-color-yellow')
//         batteryLiquid.classList.remove('gradient-color-red','gradient-color-orange','gradient-color-green')
//     }
//     else{
//         batteryLiquid.classList.add('gradient-color-green')
//         batteryLiquid.classList.remove('gradient-color-red','gradient-color-orange','gradient-color-yellow')
//     }
// }