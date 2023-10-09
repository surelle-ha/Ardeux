const web3 = require('@solana/web3.js');
const splToken = require('@solana/spl-token');
const express = require('express');

const app = express();
const port = 3000;

app.get('/test', (req, res) => {
    res.json({
        "test": new Date()
    })
});

app.get('/v1/api/token/mint', async (req, res) => {
    try {
        // Create a connection to the Devnet
        const connection = new web3.Connection(web3.clusterApiUrl('devnet'));

        // Use the provided public and secret keys
        const privateKeyBytes = [104, 156, 52, 30, 164, 214, 83, 40, 33, 147, 30, 166, 113, 187, 133, 124, 3, 251, 2, 209, 70, 165, 153, 251, 91, 227, 160, 174, 108, 199, 38, 89, 138, 107, 92, 205, 53, 43, 248, 98, 224, 38, 54, 17, 247, 124, 68, 20, 230, 228, 228, 132, 119, 9, 6, 40, 79, 156, 175, 125, 23, 29, 11, 239];

        // Create a keypair from the provided keys
        const myKeypair = web3.Keypair.fromSecretKey(Uint8Array.from(privateKeyBytes));

        console.log('Solana public address: ' + myKeypair.publicKey.toBase58());

        try {
            let tokenMintAmount = 100;

            const mintAddress = 'EaS3A3Q7Suv9D7QorMkTEYiULjhTCpLJfErGCtSd2RYJ';
            const mint = new web3.PublicKey(mintAddress); 

            let currentSupply = ((await splToken.getMint(connection, mint)).supply)
            let timestampRequested = new Date();

            const tokenAccount = await splToken.getOrCreateAssociatedTokenAccount(
                connection,
                myKeypair,
                mint,
                myKeypair.publicKey
            );

            if (tokenAccount) {
                console.error('Minting...');
                const result = await splToken.mintTo(connection, myKeypair, mint, tokenAccount.address, myKeypair.publicKey, tokenMintAmount * web3.LAMPORTS_PER_SOL);

                let newSupply = ((await splToken.getMint(connection, mint)).supply)
                res.json({
                    "mintProgress": "Success",
                    "mintedToken": tokenMintAmount,
                    "previousSupply": Number(currentSupply),
                    "newSupply": Number(newSupply),
                    "transaction": {result},
                    // "tokenAccount": tokenAccount,
                    "error": null,
                    "timestampRequested": timestampRequested,
                    "timestampComplete": new Date(),
                })

            } else {
                res.json({
                    "mintProgress": "Failed",
                    "mintedToken": 0,
                    "transaction": null,
                    // "tokenAccount": tokenAccount,
                    "previousSupply": Number(currentSupply),
                    "newSupply": Number(currentSupply),
                    "error": "Associated Token Address is undefined.",
                    "timestampRequested": timestampRequested,
                    "timestampCompleted": new Date(),
                })

            }

        } catch (error) {
        console.error('Error:', error);
        }
    } catch (error) {
        console.error('Error:', error);
    }
});

app.listen(port, () => {
    console.log(`Server is running on http://localhost:${port}`);
  });