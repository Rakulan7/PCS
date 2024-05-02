const express = require("express");
const mysql = require("mysql");
const port = process.env.PORT || 5000;

const app = express();



app.get("/", (req, res) => {
    res.status(200).json({
        message: "Bienvenue sur notre API en Node JS"
    })
})

const users = require("./routes/users")
app.use("/users", users)

const biens = require("./routes/biens")
app.use("/biens", biens)

app.listen(port, () => {
    console.log("Server is on");
})