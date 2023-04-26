
// cmd > node filename.js
// cmd > node
//       .load filename.js

// node with sql or php with mongo??

var http = require("http"); //import/use built in (core) module http
var url = require("url");
var fs = require("fs");
// var csv = require("csv");
var fsp = require("fs/promises");
const { MongoClient, ServerApiVersion } = require('mongodb');
const { error } = require("console");

const uri = "mongodb+srv://mirajain:tsoFrvgwiJk8uf4H@cluster0.gww8kzq.mongodb.net/?retryWrites=true&w=majority";
// Create a MongoClient with a MongoClientOptions object to set the Stable API version
const client = new MongoClient(uri, {
  serverApi: {
  version: ServerApiVersion.v1,
  strict: true,
  deprecationErrors: true,
  }
})

async function main() {
  try {
    // Connect the client to the server	(optional starting in v4.7)
    await client.connect().catch(function(err){console.log(err)})
    // Send a ping to confirm a successful connection
    await client.db("admin").command({ ping: 1 });
    console.log("Pinged your deployment. You successfully connected to MongoDB!");

    // insert
    coll = client.db("HW14").collection('companies')
    await csvinserts(coll);

    // query to see if insert was successful
    query = {}
    queryOptions =
    { sort: { Ticker: 1 }, projection: { _id: 0}
    };
    // wait for find operation to resolve
    console.log("ALREADY INSERTED\n")
    result = await coll.find(query, queryOptions); //findcursor is not a promise but is awaitable
    console.log(await result.toArray())
  }
  catch(error) {
    console.log(error)
  }
  finally {
    // Ensures that the client will close when you finish/error
    return await client.close();
  }
}
main().catch(console.dir);

async function csvinserts(coll){
  const file = await fsp.open('./companies.csv');
  i = 0;
  for await (const line of file.readLines()) {
      if (i == 0) {
        fieldnames = line.split(",")
      }
      else {
        vals = line.split(",")
        obj = {}
        fieldnames.forEach((e,j) => {
          obj[e] = vals[j]          
        });
        // coll.insertOne(obj)
        console.log(obj)
      }
      i++;
  }
}
csvinserts().catch(console.dir)