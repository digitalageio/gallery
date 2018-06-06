const tetrisManager = new TetrisManager(document);
const localTetris = tetrisManager.createPlayer();
localTetris.element.classList.add('local');
localTetris.run();

const connectionManager = new ConnectionManager(tetrisManager);
connectionManager.connect('ws://192.168.1.5:9000');

const keyListener = (event) => {
	[
		[83, 70, 68, 81, 87],
		[37, 39, 40, 188, 190]

	].forEach((key, index) => {
		const player = localTetris.player;
		if(event.type === 'keydown'){
			switch(event.keyCode){
				case key[0]: //left
					player.move(-1);
					break;
				case key[1]: //right
					player.move(1);
					break;
				case key[2]: //down
					player.drop();
					player.dropInterval = player.DROP_FAST;
					break;
				case key[3]: //q
					player.rotate(-1);
					break;
				case key[4]: //w
					player.rotate(1);
					break;
				default:
					break;
			}
		}

		if(event.keyCode === key[2] && event.type === 'keyup'){ //down
			player.dropInterval = player.DROP_SLOW;
		}
	});
};

document.addEventListener('keydown', keyListener);
document.addEventListener('keyup', keyListener);