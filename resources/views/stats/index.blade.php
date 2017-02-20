@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-6">
		<canvas id="age-graph"></canvas>
	</div>

  <div class="col-sm-12 col-md-12 col-lg-6">
    <canvas id="gender-graph"></canvas>
  </div>
</div>

<div class="row">
  <div class="col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
    <canvas id="municipality-graph"></canvas>
  </div>
</div>

<div class="row">
  <div class="col-sm-12 col-md-12 col-lg-12">
    <canvas id="dental-disease-graph"></canvas>
  </div>
</div>

<div class="row">
  <div class="col-sm-12 col-md-12 col-lg-12">
    <canvas id="general-disease-graph"></canvas>
  </div>
</div>


@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script>
var context = document.querySelector('#age-graph').getContext('2d');

var data = {
  labels: {!! json_encode($stats['keys']['age']) !!},
  datasets: [
    {
      label: "No. de pacientes por edad",
            backgroundColor: "rgba(75,192,192,0.4)",
            borderColor: "rgba(75,192,192,1)",
            borderCapStyle: 'butt',
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            data: {!! json_encode($stats['values']['age']) !!},
            spanGaps: false,
    }
  ]
};

new Chart(context, {
  type: 'bar',
  data: data,
  options: {
    scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    }
  }
});

context = document.querySelector('#gender-graph').getContext('2d');

data = {
  labels: {!! json_encode($stats['keys']['gender']) !!},
  datasets: [
    {
      label: "No. pacientes por sexo",
            backgroundColor: "rgba(75,192,192,0.4)",
            borderColor: "rgba(75,192,192,1)",
            borderCapStyle: 'butt',
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            data: {!! json_encode($stats['values']['gender']) !!},
            spanGaps: false,
    }
  ]
};

new Chart(context, {
  type: 'bar',
  data: data,
  options: {
    scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    }
  }
});

context = document.querySelector('#municipality-graph').getContext('2d');

data = {
  labels: {!! json_encode($stats['keys']['municipality']) !!},
  datasets: [
    {
      label: "No. pacientes por municipio",
            backgroundColor: "rgba(75,192,192,0.4)",
            borderColor: "rgba(75,192,192,1)",
            borderCapStyle: 'butt',
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            data: {!! json_encode($stats['values']['municipality']) !!},
            spanGaps: false,
    }
  ]
};

new Chart(context, {
  type: 'bar',
  data: data,
  options: {
    scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    }
  }
});

context = document.querySelector('#dental-disease-graph').getContext('2d');

data = {
  labels: {!! json_encode($stats['keys']['dental_disease']) !!}.map(function(disease) { return disease.substr(0, 30) + '...'; }),
  datasets: [
    {
      label: "Enfermedades Odontologicas",
            backgroundColor: "rgba(75,192,192,0.4)",
            borderColor: "rgba(75,192,192,1)",
            borderCapStyle: 'butt',
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            data: {!! json_encode($stats['values']['dental_disease']) !!},
            spanGaps: false,
    }
  ]
};

new Chart(context, {
  type: 'bar',
  data: data,
  options: {
    scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    }
  }
});

context = document.querySelector('#general-disease-graph').getContext('2d');

data = {
  labels: {!! json_encode($stats['keys']['general_disease']) !!},
  datasets: [
    {
      label: "Enfermedades Generales",
            backgroundColor: "rgba(75,192,192,0.4)",
            borderColor: "rgba(75,192,192,1)",
            borderCapStyle: 'butt',
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            data: {!! json_encode($stats['values']['general_disease']) !!},
            spanGaps: false,
    }
  ]
};

new Chart(context, {
  type: 'bar',
  data: data,
  options: {
    scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    }
  }
});

</script>	
@endpush
@endsection