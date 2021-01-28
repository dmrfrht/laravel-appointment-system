const app = require('express')()
const http = require('http').Server(app)
const io = require('socket.io')(http)

app.get('/', (req, res) => {
  res.send('burası anasayfa')
})

io.on('connection', (socket) => {
  socket.on('new_appointment_create', function () {
    io.emit('admin_appointment_list')
  })
})


http.listen(3000, () => {
  console.log('express server ayakta')
})


