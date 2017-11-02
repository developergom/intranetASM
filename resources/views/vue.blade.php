<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>Vue</title>
	<script src="https://unpkg.com/vue"></script>
</head>
<body>
<div id="app">
  <p>@{{ message }}</p>
</div>
<div id="app-2">
	<span v-bind:title="message">
		Hover your mouse over me for a few seconds to see my dinamically bound title!
	</span>
</div>
<div id="app-3">
	<span v-if="seen">Now You See Me</span>
</div>
<div id="app-4">
	<ol>
		<li v-for="todo in todos">
			@{{ todo.text }}
		</li>
	</ol>
</div>
<div id="app-5">
	<p>@{{ message }}</p>
	<button v-on:click="reverseMessage">Reverse Message</button>
</div>
<div id="app-6">
	<p>@{{ message }}</p>
	<input v-model="message">
</div>
<div id="app-7">
	<ol>
		<todo-item v-for="item in groceryList" v-bind:todo="item" v-bind:key="item.id">
		</todo-item>
	</ol>
</div>
<script type="text/javascript">
    new Vue({
      el: '#app',
      data: {
        message: 'Hello Vue.js!'
      }
    })

    var app2 = new Vue({
    	el: '#app-2',
    	data: {
    		message: 'You loaded this page on ' + new Date().toLocaleString()
    	}
    })

    var app3 = new Vue({
    	el: '#app-3',
    	data: {
    		seen: true
    	}
    })

    var app4 = new Vue({
    	el: '#app-4',
    	data: {
    		todos: [
    			{ text: 'Learn Javascript' },
    			{ text: 'Learn Learn Vue' },
    			{ text: 'Build something awesome' }
    		]
    	}
    })

    var app5 = new Vue({
    	el: '#app-5',
    	data: {
    		message: 'Hello Vue.js!'
    	},
    	methods: {
    		reverseMessage: function() {
    			this.message = this.message.split('').reverse().join(' ')
    		}
    	}
    })

    var app6 = new Vue({
    	el: '#app-6',
    	data: {
    		message: 'Hello Vue.js!'
    	}
    })

    Vue.component('todo-item', {
    	props: ['todo'],
    	template: '<li>@{{ todo.text }}</li>'
    })

    var app7 = new Vue({
    	el: '#app-7',
    	data: {
    		groceryList: [
    			{ id: 0, text: 'Vegetables' },
    			{ id: 1, text: 'Cheese' },
    			{ id: 2, text: 'Indomie' },
    			{ id: 3, text: 'Whatever else humans are supposed to eat' }
    		]
    	}
    })
</script>
</body>
</html>