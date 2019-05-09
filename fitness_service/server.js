const { ThaiCardReader, EVENTS, MODE } = require('./index')
const path = require('path');
const request = require('request')
const fs = require('fs')
const today = new Date();
const express = require('express')
const app = express()
const port = 3000
app.listen(port)
const reader = new ThaiCardReader()
reader.readMode = MODE.PERSONAL_PHOTO
reader.autoRecreate = true
reader.startListener()

reader.on(EVENTS.CARD_INSERTED, () => {
  console.log(today + 'Card Inserted')
  let student = {
    ststus: 'Inserted',
    citizenId: '',
    titleTH: '',
    firstNameTH: '',
    lastNameTH: '',
    titleEN: '',
    firstNameEN: '',
    lastNameEN: '',
    birthday: '',
    gender: '',
    address: '',
    issue: '',
    expire: '',
    photo: '',
  }
  let data = JSON.stringify(student);
  fs.writeFileSync('json/student.json', data);
    app.get('/', (req, res) => {
      res.header("Content-Type", 'application/json');
      res.header("Access-Control-Allow-Origin", "*");
      res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
      res.sendFile(path.join(__dirname, 'json/student.json'));
    })
})

reader.on(EVENTS.CARD_REMOVED, () => {
  console.log(today + 'Card Removed')
  let student = {
    status: 'Remove',
    citizenId: '',
    titleTH: '',
    firstNameTH: '',
    lstNameTH: '',
    titleEN: '',
    firstNameEN: '',
    lastNameEN: '',
    birthday: '',
    gender: '',
    address: '',
    issue: '',
    expire: '',
    photo: '',
  }
  let data = JSON.stringify(student);
  fs.writeFileSync('json/student.json', data);
    app.get('/', (req, res) => {
      res.header("Content-Type", 'application/json');
      res.header("Access-Control-Allow-Origin", "*");
      res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
      res.sendFile(path.join(__dirname, 'json/student.json'));
    })
})

reader.on(EVENTS.READING_INIT, () => {
  console.log(today + 'Initial Reading')
  let student = {
    status: 'Reading',
    citizenId: '',
    titleTH: '',
    firstNameTH: '',
    lastNameTH: '',
    titleEN: '',
    firstNameEN: '',
    lastNameEN: '',
    birthday: '',
    gender: '',
    address: '',
    issue: '',
    expire: '',
    photo: '',
  }
  let data = JSON.stringify(student);
  fs.writeFileSync('json/student.json', data);
    app.get('/', (req, res) => {
      res.header("Content-Type", 'application/json');
      res.header("Access-Control-Allow-Origin", "*");
      res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
      res.sendFile(path.join(__dirname, 'json/student.json'));
    })
})
reader.on(EVENTS.READING_FAIL, () => {
  console.log(today + 'Reading Fail')
  let student = {
    status: 'Fail',
    citizenId: '',
    titleTH: '',
    firstNameTH: '',
    lastNameTH: '',
    titleEN: '',
    firstNameEN: '',
    lastNameEN: '',
    birthday: '',
    gender: '',
    address: '',
    issue: '',
    expire: '',
    photo: '',
  }
  let data = JSON.stringify(student);
  fs.writeFileSync('json/student.json', data);
    app.get('/', (req, res) => {
      res.header("Content-Type", 'application/json');
      res.header("Access-Control-Allow-Origin", "*");
      res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
      res.sendFile(path.join(__dirname, 'json/student.json'));
    })
})

reader.on(EVENTS.READING_COMPLETE, (obj) => {
  console.log(today + 'Initial Success')
  let student = {
    status: 'Success',
    citizenId: obj['citizenId'],
    titleTH: obj['titleTH'],
    firstNameTH: obj['firstNameTH'],
    lastNameTH: obj['lastNameTH'],
    titleEN: obj['titleEN'],
    firstNameEN: obj['firstNameEN'],
    lastNameEN: obj['lastNameEN'],
    birthday: obj['birthday'],
    gender: obj['gender'],
    address: obj['address'],
    issue: obj['issue'],
    expire: obj['expire'],
    photo: obj['photo'],
  }
  let data = JSON.stringify(student);
  fs.writeFileSync('json/student.json', data);
    app.get('/', (req, res) => {
      res.header("Content-Type", 'application/json');
      res.header("Access-Control-Allow-Origin", "*");
      res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
      res.sendFile(path.join(__dirname, 'json/student.json'));
    })
})

reader.on(EVENTS.DEVICE_DISCONNECTED, () => {
  console.log(today + 'Device Disconnect')
  let student = {
    status: 'Device Disconnect',
    citizenId: '',
    titleTH: '',
    firstNameTH: '',
    lastNameTH: '',
    titleEN: '',
    firstNameEN: '',
    lastNameEN: '',
    birthday: '',
    gender: '',
    address: '',
    issue: '',
    expire: '',
    photo: '',
  }
  let data = JSON.stringify(student);
  fs.writeFileSync('json/student.json', data);
    app.get('/', (req, res) => {
      res.header("Content-Type", 'application/json');
      res.header("Access-Control-Allow-Origin", "*");
      res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
      res.sendFile(path.join(__dirname, 'json/student.json'));
    })
})