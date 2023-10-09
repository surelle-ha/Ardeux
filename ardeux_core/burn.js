const web3 = require('@solana/web3.js');
const splToken = require('@solana/spl-token');

(async () => {
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

            console.log("Current Token Supply: " + ((await splToken.getMint(connection, mint)).supply));

            const tokenAccount = await splToken.getOrCreateAssociatedTokenAccount(
                connection,
                myKeypair,
                mint,
                myKeypair.publicKey
            );

            if (tokenAccount) {
                console.error('Minting...');
                const result = await splToken.mintTo(connection, myKeypair, mint, tokenAccount.address, myKeypair.publicKey, tokenMintAmount * web3.LAMPORTS_PER_SOL);
                console.log(`Minted ${tokenMintAmount} new tokens`);
            } else {
                console.error('Associated Token Address is undefined.');
            }

            console.log("New Token Supply: " + ((await splToken.getMint(connection, mint)).supply));

        } catch (error) {
        console.error('Error:', error);
        }
    } catch (error) {
        console.error('Error:', error);
    }
})();
