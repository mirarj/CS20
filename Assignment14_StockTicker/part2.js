
// cmd > node filename.js
// cmd > node
//       .load filename.js

var http = require("http"); //import/use built in (core) module http
var url = require("url");
var fs = require("fs");

const { MongoClient, ServerApiVersion } = require('mongodb');
const { error } = require("console");
const { resolve } = require("path");

const uri = "mongodb+srv://mirajain:tsoFrvgwiJk8uf4H@cluster0.gww8kzq.mongodb.net/?retryWrites=true&w=majority";
// Create a MongoClient with a MongoClientOptions object to set the Stable API version
const client = new MongoClient(uri, {
  serverApi: {
  version: ServerApiVersion.v1,
  strict: true,
  deprecationErrors: true,
  }
})

async function query_mongo(inputval, inputtype) {
  try {
    // Connect the client to the server	(optional starting in v4.7)
    await client.connect().catch(function(err){console.log(err)})
    // Send a ping to confirm a successful connection
    await client.db("admin").command({ ping: 1 });
    console.log("Pinged your deployment. You successfully connected to MongoDB!");

    // insert
    coll = client.db("HW14").collection('companies')
    // query to see if insert was successful
    if (inputtype=="symbol"){
        query = {Ticker: inputval}
    }
    else {
        query = {Company: new RegExp(inputval, 'i')}
    }
    queryOptions = {projection: { _id: 0}};
    // wait for find operation to resolve
    result = await coll.find(query, queryOptions);
    array = await result.toArray()
  }
  catch(error) {
    console.log(error)
  }
  finally {
    // Ensures that the client will close when you finish/error
    await client.close();
    return array
  }
}
query_mongo().catch(console.dir);

async function loadhtml(res) {
    return await new Promise((resolve, reject) => {
        fs.readFile('part2.html', async function(err,data){
            if (err){
                console.log(err)
                reject()
            }
            else{
                await res.write(data)
                resolve()
            }})
    })

}

http.createServer(async function(req,res) {
    // req is request object coming into the server
    // res is the response object going out to the client

    myurl = new URL(req.url, "https://example.org/")
    res.writeHead(200, {'Content-Type':'text/html'});

    if (myurl.pathname=="/"){
        await loadhtml(res)
    }
    else if (myurl.pathname=="/process"){
        type = myurl.searchParams.get("inputtype")
        val = myurl.searchParams.get("inputval")

        records = await query_mongo(val, type)

        if (records.length == 0){
            res.write("No records found")
        }
        else {
            res.write("<table>")
            res.write("<tr><th>Company</th><th>Ticker</th><th>Price</th></tr>")
            records.forEach(element => {
                res.write("<tr>")
                res.write("<td>" + element['Company'] + "</td>")
                res.write("<td>" + element['Ticker'] + "</td>")
                price = parseFloat(element['Price']).toFixed(2)
                res.write("<td>$" + price + "</td>")
                res.write("</tr>")
            });
            res.write("</table>")
        };
    
    }
    res.end()
        
}).listen(8000)
    // browser: http://localhost:8000/

